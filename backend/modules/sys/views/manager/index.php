<div class="layui-fluid">   
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">登录名</label>
                    <div class="layui-input-block">
                        <input type="text" name="loginname" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">手机</label>
                    <div class="layui-input-block">
                        <input type="text" name="telphone" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-block">
                        <select name="role">
                            <option value="0">管理员</option>
                            <option value="1">超级管理员</option>
                            <option value="2">纠错员</option>
                            <option value="3">采购员</option>
                            <option value="4">推销员</option>
                            <option value="5">运营人员</option>
                            <option value="6">编辑</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit="" lay-filter="LAY-user-back-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
      
        <div class="layui-card-body">

            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
            </div>
        
            <div class="layui-form layui-border-box layui-table-view">
                <div class="layui-table-box">
                    <div class="layui-table-header" style="width: 100%;">
                        <table class="layui-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">
                                        <div class="layui-table-cell" align="center">
                                            <span>ID</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>登录名</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>昵称</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>手机</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>邮箱</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>角色</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>加入时间</span>
                                        </div>
                                    </th>
                                    <th class="layui-table-col-special" style="width: 11%;">
                                        <div class="layui-table-cell" align="center">
                                            <span>操作</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="layui-table-body layui-table-main" style="width: 100%;">
                        <table class="layui-table" style="width: 100%;">
                            <tbody>

                                <?php foreach ($models as $model): ?>
                                <tr>
                                    <td style="width: 5%;">
                                        <div class="layui-table-cell" align="center"><?php echo $model['id']; ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo $model['username']; ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo $model['nickname'] ?: $model['username']; ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo $model['mobile_phone'] ?: '提醒该用户及时登记'; ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo $model['email'] ?: '提醒该用户及时登记'; ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo $model['roleName'] ?: '未分配'  ?></div>
                                    </td>
                                    <td style="width: 14%;">
                                        <div class="layui-table-cell"><?php echo date('Y/m/d H:i', $model['append']); ?></div>
                                    </td>
                                    
                                    <td align="center" class="layui-table-col-special" style="width: 11%;">
                                        <div class="layui-table-cell">
                                            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">
                                                <i class="layui-icon layui-icon-edit"></i>编辑
                                            </a>
                                            <a class="layui-btn <?php echo in_array($model['id'], Yii::$app -> params['adminAccount']) ? 'layui-btn-disabled' : 'layui-btn-danger'; ?>  layui-btn-xs">
                                                <i class="layui-icon layui-icon-delete"></i>删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div>  

        </div>
    </div>
</div>