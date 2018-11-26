<?php
namespace oframe\basics\common\helpers;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * mysql 数据库 备份 还原 助手类
 * 
 */
class MySQLHelper
{

    public $config = [];

    private $content;

    private $dbname = [];

    private $con;

    const DIR_SEP = DIRECTORY_SEPARATOR; // 操作系统的目录分隔符

    // 初始化相关数据
    public function __construct()
    {

        header ('Content-type: text/html;charset=utf-8');

        $dsn = explode('=', implode('=', explode(';', Yii::$app -> db -> dsn)));

        $_config = [
            'host'           => $dsn[1],
            'dbname'         => $dsn[3],
            'port'           => 3306,
            'username'       => Yii::$app -> db -> username,
            'password'       => Yii::$app -> db -> password,
            'charset'        => Yii::$app -> db -> charset,
            'tablePrefix'    => Yii::$app -> db -> tablePrefix,
            'path'           => Yii::getAlias('@common') . '/backup/mysql/', // 备份文件路径
            'isCompress'     => 1, // 是否开启gzip压缩[0:不开启,1:开启]
            'isDownload'     => 0, // 压缩后是否自动下载[0:不自动,1:自动]
            'safe_delimiter' => ';/* MySQLReback Separation */', // 安全分隔符(必须)
        ];

        $this -> config = ArrayHelper::merge($_config, $this -> config);

        try {

            $this -> con = $this -> connect();

        } catch (\Exception $e) {

            print_r($e -> getMessage());exit;

        }

    }

    /**
     * 设置预备份的数据库
     * @param string|array $dbname 数据库名 [支持多个参数]['':默认备份main-local数据库, '*':备份所有数据库, [array]:指定的数据库]
     */
    public function setDbname($dbname = '')
    {

        $dbname = $dbname ? $dbname : $this -> config['dbname'];

        if ($dbname == '*') {

            $rs = mysql_list_dbs();

            $rows = mysqli_num_rows($rs);

            if ($rows) {

                for ($i = 0; $i < $rows; $i++) {

                    $dbname = mysql_tablename($rs, $i);

                    // 这些数据库不需要备份
                    $block = ['information_schema', 'mysql'];

                    if (!in_array($dbname, $block)) $this -> dbname[] = $dbname;

                }

            } else {

                $this -> throwException('没有任何数据库!');

            }

        } else {

            if (is_array($dbname)) {

                $this -> dbname = $dbname;

            } else {

                $this -> dbname[] = $dbname;

            }

        }

    }


    /**
     * 备份
     */
    public function backup()
    {
        $this -> content = '/* This file is created by MySQLReback ' . date('Y-m-d H:i:s') . ' */';

        foreach ($this -> dbname as $dbname) {

            $qdbname = $this -> backquote($dbname);

            $rs = mysqli_query($this -> con, "SHOW CREATE DATABASE {$qdbname}");

            if ($rs && $row = mysqli_fetch_row($rs)) {

                // 建立数据库
                $this -> content .= "\r\n /* 创建数据库 {$qdbname} */";

                // 必须设置一个分隔符, 单用分号不够安全
                $this -> content .= "\r\n DROP DATABASE IF EXISTS {$qdbname}{$this -> config['safe_delimiter']} {$row[1]}{$this -> config['safe_delimiter']}";

                mysqli_select_db($this -> con, $dbname);

                // 取得表
                $tables = $this -> getTables($dbname);

                foreach ($tables as $table) {

                    $table = $this -> backquote($table);

                    $tableRs = mysqli_query($this -> con, "SHOW CREATE TABLE {$table}");

                    if ($tableRow = mysqli_fetch_row($tableRs)) {

                        // 建表
                        $this -> content .= "\r\n /* 创建表结构 {$table} */";

                        $this -> content .= "\r\n DROP TABLE IF EXISTS {$table}{$this -> config['safe_delimiter']} {$tableRow[1]}{$this -> config['safe_delimiter']}";

                        // 获取数据
                        $tableDateRs = mysqli_query($this -> con, "SELECT * FROM {$table}");

                        $valuesArr = [];

                        $values = '';

                        while ($tableDateRow = mysqli_fetch_row($tableDateRs)) {

                            // 组合INSERT的VALUE
                            foreach ($tableDateRow as $k => $v) {

                                // 别忘了转义  value为空则空字符''  否则为 'value'
                                if (is_null($v)) {

                                    $tableDateRow[$k] = 'NULL';

                                } else {

                                    $tableDateRow[$k] = ($v || is_numeric($v)) ? "'" . addslashes($v) . "'" : "''"; 
                                    
                                }

                            }

                            $valuesArr[] = '(' . implode(',', $tableDateRow) . ')';

                        }

                        $temp = $this -> chunkArrayByByte($valuesArr);

                        if (is_array($temp)) {

                            foreach ($temp as $v) {

                                $values = implode(',', $v) . $this -> config['safe_delimiter'];

                                // 空的数据表不需要组合SQL语句
                                if ($values != $this -> config['safe_delimiter']) {

                                    $this -> content .= "\r\n /* 插入数据 {$table} */";

                                    $this -> content .= "\r\n INSERT INTO {$table} VALUES {$values}";

                                }

                            }

                        }

                    }

                }

            } else {

                $this -> throwException('未能找到数据库');

            }

        }

        if (!empty($this -> content)) {

            $this -> setFile();

        }

        return true;
    }

    /**
     * 恢复数据库
     * @param string $fileName 文件名
     */
    public function recover($fileName) {

        mysqli_autocommit($this -> con, false); // 设置为非自动提交——事务处理

        $this -> getFile($fileName);

        if (!empty($this -> content)) {

            $content = explode($this -> config['safe_delimiter'], $this -> content);

            foreach ($content as $sql) {

                $sql = trim($sql);

                // 空的sql会被认为是错误的
                if (!empty($sql)) {

                    $rs = mysqli_query($this -> con, $sql);

                    if ($rs) {

                        // 一定要选择数据库，不然多库恢复会出错
                        if (strstr($sql, 'CREATE DATABASE')) {

                            $dbnameArr = sscanf($sql, 'CREATE DATABASE %s');

                            $dbname = trim($dbnameArr[0], '`');

                            mysqli_select_db($this -> con, $dbname);

                        }

                        mysqli_commit($this -> con); // 全部成功，提交执行结果

                    } else {

                        mysqli_rollback($this -> con); // 回滚并取消执行结果

                        $this -> throwException('备份文件被损坏 ' . mysqli_error());

                    }

                }

            }

        } else {

            mysqli_rollback($this -> con); // 回滚并取消执行结果

            $this -> throwException('无法读取备份文件');

        }

        mysqli_autocommit($this -> con, true); // 开启自动提交

        return true;
    }


    /**
     * 优化数据表 【分 innoDB 和 非 innoDB】
     * @param string|array $tables 数据表 ['':默认对应数据库的所有数据表,'tablename':tablename数据表,[]:指定多个数据表]
     */
    public function optimize($tables = '')
    {
        foreach ($this -> dbname as $dbname) {
            // 多数据库

            $qdbname = $this -> backquote($dbname); // 为dbname添加``

            $rs = mysqli_query($this -> con, "SHOW CREATE DATABASE {$qdbname}");

            if ($rs && $row = mysqli_fetch_row($rs)) {
                // 数据库存在

                mysqli_select_db($this -> con, $dbname);

                if ($tables) {
                    // 指定表优化

                    if (is_array($tables)) {
                        // 指定多表优化

                        $sql = $this -> exportOptSql($dbname, $tables); // 获取优化语句 分 InnoDB和非InnoDB

                        foreach ($sql['InnoDB'] as $v) {

                            $in_rs = $v ? mysqli_query($this -> con, $v) : false;

                            if (!$in_rs) {

                                $table = explode('`', $v);

                                $this -> throwException("InnoDB数据表 `{$table}` 优化出错");

                            }

                        }

                        $ot_rs = $sql['OtherDB'] ? mysqli_query($this -> con, "OPTIMIZE TABLE `{$sql['OtherDB']}`") : true;

                        if (!$ot_rs) {

                            $this -> throwException("非InnoDB数据表优化出错");

                        }

                    } else {
                        // 指定单表优化

                        $engine = $this -> getEngine($dbname, $tables); // 获取表存储引擎

                        if ($engine == 'InnoDB') {

                            $rs = mysqli_query($this -> con, "ALTER TABLE `{$tables}` ENGINE='InnoDB'");

                        } else {

                            $rs = mysqli_query($this -> con, "OPTIMIZE TABLE `{$tables}`");

                        }

                        if (!$rs) {

                            $this -> throwException("数据表 `{$tables}` 优化出错");

                        }

                    }

                } else {
                    // 所有表优化

                    $tables = $this -> getTables($dbname); // 获取所有表

                    $sql = $this -> exportOptSql($dbname, $tables);

                    foreach ($sql['InnoDB'] as $v) {

                        $in_rs = $v ? mysqli_query($this -> con, $v) : false;

                        if (!$in_rs) {

                            $table = explode('`', $v);

                            $this -> throwException("InnoDB数据表 `{$table}` 优化出错");

                        }

                    }

                    $ot_rs = $sql['OtherDB'] ? mysqli_query($this -> con, "OPTIMIZE TABLE `{$sql['OtherDB']}`") : true;

                    if (!$ot_rs) {

                        $this -> throwException("非InnoDB数据表优化出错");

                    }

                }

            } else {

                $this -> throwException("未能找到 `{$dbname}` 数据库");

            }

        }

        return true;
    }


    /**
     * 数据表修复 【innoDB表有自动修复机制，数据修复只针对非innoDB表】
     * @param string|array $tables 数据表 ['':默认对应数据库的所有数据表,'tablename':tablename数据表,[]:指定多个数据表]
     */
    public function repair($tables = '')
    {
        foreach ($this -> dbname as $dbname) {
            // 多数据库
            
            $qdbname = $this -> backquote($dbname); // 为dbname添加``

            $rs = mysqli_query($this -> con, "SHOW CREATE DATABASE {$qdbname}");

            if ($rs && $row = mysqli_fetch_row($rs)) {
                // 数据库存在

                mysqli_select_db($this -> con, $dbname);

                if ($tables) {
                    // 指定表修复

                    if (is_array($tables)) {
                        // 指定多表修复

                        $tables = implode('`,`', $tables);

                        $rs = mysqli_query($this -> con, "REPAIR TABLE `{$tables}`");

                    } else {
                        // 指定单表修复

                        $rs = mysqli_query($this -> con, "REPAIR TABLE `{$tables}`");

                        if (!$rs) {

                            $this -> throwException("数据表 `{$tables}` 修复失败");

                        }

                    }

                } else {
                    // 所有表修复

                    $tables = $this -> getTables($dbname); // 获取所有表

                    $tables = implode('`,`', $tables);

                    $rs = mysqli_query($this -> con,  "REPAIR TABLE `{$tables}`");

                }

                if (!$rs) {

                    $this -> throwException('数据表修复失败');

                }

            } else {

                $this -> throwException("未能找到 `{$dbname}` 数据库");

            }

        }

        return true;
    }


    /**
     * 连接数据库
     */
    private function connect()
    {
        if ($con = mysqli_connect($this -> config['host'] . ':' . $this -> config['port'], $this -> config['username'], $this -> config['password'], $this -> config['dbname'])) {

            mysqli_query($con, "SET NAMES '{$this -> config['charset']}'");

            mysqli_query($con, "set interactive_timeout = 24*3600");

        } else {

            $this -> throwException('无法链接到数据库');

        }

        return $con;
    }


    /**
     * 获取备份文件
     * @param string $fileName 文件名
     */
    private function getFile($fileName)
    {
        $this -> content = '';

        $fileName = $this -> trimPath($this -> config['path'] . self::DIR_SEP . $fileName);

        if (is_file($fileName)) {

            $ext = strrchr($fileName, '.');

            if ($ext == '.sql') {

                $this -> content = file_get_contents($fileName);

            } else if ($ext == '.gz') {

                $this -> content = implode('', gzfile($fileName));

            } else {

                $this -> throwException('无法识别的文件格式');

            }

        } else {

            $this -> throwException('文件不存在');

        }
    }


    /**
     * 备份文件
     */
    private function setFile()
    {
        $recognize = '';

        $recognize = implode('_', $this -> dbname);

        $fileName = $this -> trimPath($this -> config['path'] . self::DIR_SEP . $recognize . '_' . date('YmdHis') . '_' . mt_rand(100000000, 999999999) . '.sql');

        $path = $this -> setPath($fileName);

        if ($path !== true) {

            $this -> throwException("无法创建备份目录 '$path' ");

        }

        if ($this -> config['isCompress'] == 0) {

            if (!file_put_contents($fileName, $this -> content, LOCK_EX)) {

                $this -> throwException('写入文件失败，请检查磁盘空间或者权限');

            }

        } else {

            if (function_exists('gzwrite')) {

                $fileName .= '.gz';

                if ($gz = gzopen($fileName, 'wb')) {

                    gzwrite($gz, $this -> content);

                    gzclose($gz);

                } else {

                    $this -> throwException('写入文件失败，请检查磁盘空间或者权限');

                }

            } else {

                $this -> throwException('没有开启gzip扩展');

            }

        }

        if ($this -> config['isDownload']) {

            $this -> downloadFile($fileName);

        }

    }


    /**
     * 将路径修正为适合操作系统的格式
     * @param string $path 路径名称
     */
    private function trimPath($path)
    {
        return str_replace(['/', '\\', '//', '\\\\'], self::DIR_SEP, $path);
    }

    /**
     * 设置并创建目录
     * @param string $fileName 路径
     */
    private function setPath($fileName)
    {
        $dirs = explode(self::DIR_SEP, dirname($fileName));

        $tmp = '';

        foreach ($dirs as $dir) {

            $tmp .= $dir . self::DIR_SEP;

            if (!file_exists($tmp) && !@mkdir($tmp, 0777)) {

                return $tmp;

            }

        }

        return true;

    }

    /**
     * 下载文件
     * @param string $fileName 路径
     */
    private function downloadFile($fileName)
    {
        header ("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header ('Content-Description: File Transfer');
        header ('Content-Type: application/octet-stream');
        header ('Content-Length: ' . filesize($fileName));
        header ('Content-Disposition: attachment; filename=' . basename($fileName));
        readfile($fileName);
    }

    /**
     * 给表名或者数据库名加上``
     * @param string $fileName 路径
     */
    private function backquote($str)
    {
        return "`{$str}`";
    }

    /**
     * 获取数据库的所有表
     * @param string $dbname 数据库名
     */
    private function getTables($dbname)
    {
        $tables = mysqli_query($this -> con, "SHOW TABLES FROM `{$dbname}`");

        while (list($table) = mysqli_fetch_row($tables)) {

            $result[] = $table;

        }

        return $result;
    }


    /**
     * 获取数据表的存储引擎
     * @param 
     */
    private function getEngine($dbname, $table)
    {
        $qdbname = $this -> backquote($dbname); // 为dbname添加``

        $sql = "SHOW TABLE STATUS FROM {$qdbname} where name='{$table}'";

        $ts = mysqli_query($this -> con, $sql);

        return $engine = mysqli_fetch_row($ts)[1]; // 存储引擎
    }

    /**
     * 生成 sql 优化数据表语句
     * @param string $dbname 数据库
     * @param array $tables 数据表
     */
    private function exportOptSql($dbname, $tables)
    {
        $sql = [
            'InnoDB' => [],
            'OtherDB' => []
        ];

        foreach ($tables as $table) {

            $engine = $this -> getEngine($dbname, $table);

            if (!$engine) {

                $this -> throwException("未能找到 `{$table}` 数据表");

            } else if ($engine == 'InnoDB') {

                $sql['InnoDB'][] = "ALTER TABLE `{$table}` ENGINE='InnoDB';";

            } else {

                $sql['OtherDB'][] = $table;

            }

        }

        $sql['OtherDB'] = $sql['OtherDB'] ? implode('`,`', $sql['OtherDB']) : '';

        return $sql;
    }

    /**
     * 将数组按照字节数分割成小数组
     * @param array $array 数组
     * @param int $byte 字节数
     */
    private function chunkArrayByByte($array, $byte = 5120)
    {
        $i = 0;

        $sum = 0;

        $return = [];

        foreach ($array as $v) {

            $sum += strlen($v);

            if ($sum < $byte) {

                $return[$i][] = $v;

            } else if ($sum == $byte) {

                $return[++$i][] = $v;

                $sum = 0;

            } else {
                
                $return[++$i][] = $v;

                $i++;

                $sum = 0;

            }

        }

        return $return;
    }

    /**
     * 抛出异常信息
     */
    private function throwException($error)
    {
        // 抛出异常会停止继续执行，可能有些地方用到了事务处理，关闭了自动提交
        mysqli_autocommit($this -> con, true);

        throw new \Exception($error);
    }

}