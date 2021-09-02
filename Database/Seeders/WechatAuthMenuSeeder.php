<?php
namespace Modules\WechatApplet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @author liming
 * @date 2021-08-27
 */
class WechatAuthMenuSeeder extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('auth_menu')){
            $arr = $this->defaultInfo();
            if(!empty($arr) && is_array($arr)) {
                // 删除原来已存在的菜单
                $module = config('wechatappletconfig.module') ?? "";
                if($module != ""){
                    DB::table('auth_menu')->where("module", $module)->delete();
                }

                $this->addInfo($arr);
            }
        }
    }

    /**
     * 遍历新增菜单
     * @param array $data
     * @param int $pid
     */
    private function addInfo(array $data, $pid = 0)
    {
        foreach ($data as $item) {
            $newPid = DB::table('auth_menu')->insertGetId([
                'pid' => $item['pid'] ?? $pid,
                'href' => $item['href'],
                'title' => $item['title'],
                'icon' => $item['icon'],
                'type' => $item['type'],
                'status' => $item['status'],
                'sort' => $item['sort'] ?? 0,
                'remark' => $item['remark'],
                'target' => $item['target'],
                'createtime' => $item['createtime'],
                'module' => $item["module"],
                'menus' => $item["menus"],
            ]);
            if($newPid <= 0) break;
            if(isset($item["contents"]) && is_array($item["contents"]) && !empty($item["contents"])) $this->addInfo($item["contents"], $newPid);
        }
    }

    /**
     * 设置后台管理菜单路由信息
     * @pid 父级
     * @href 路由
     * @title 菜单标题
     * @icon 图标
     * @type int 类型 0 顶级目录 1 目录 2 菜单 3 按钮
     * @status 状态 1 正常 2 停用
     * @remark 备注
     * @target 跳转方式
     * @createtime 创建时间
     */
    private function defaultInfo()
    {
        $module = config('wechatappletconfig.module') ?? "";
        $time = time();
        return [
            [
                "pid" => 10002,
                "href" => "",
                "title" => "微信小程序",
                "icon" => 'fa fa-cog',
                "type" => 1,
                "status" => 1,
                "sort" => 100,
                "remark" => "微信小程序",
                "target" => "_self",
                "createtime" => $time,
                'module' => $module,
                "menus" => $module == "" ? $module : $module . "-1",
                "contents" => [
                    [   //  订阅消息设置
                        "href" => "/admin/wechat_applet/template",
                        "title" => "订阅消息",
                        "icon" => 'fa fa-commenting',
                        "type" => 2,
                        "status" => 1,
                        "remark" => "订阅消息",
                        "target" => "_self",
                        "createtime" => $time,
                        'module' => $module,
                        "menus" => $module == "" ? $module : $module . "-2",
                        "contents" => [
                            [
                                "href" => "/admin/wechat_applet/template",
                                "title" => "订阅消息",
                                "icon" => 'fa fa-window-maximize',
                                "type" => 3,
                                "status" => 1,
                                "remark" => "订阅消息",
                                "target" => "_self",
                                "createtime" => $time,
                                'module' => $module,
                                "menus" => $module == "" ? $module : $module . "-3",
                            ]
                        ],
                    ],
                    [   //  小程序设置
                        "href" => "/admin/wechat_applet/setting",
                        "title" => "基础配置",
                        "icon" => 'fa fa-cog',
                        "type" => 2,
                        "status" => 1,
                        "remark" => "基础配置",
                        "target" => "_self",
                        "createtime" => $time,
                        'module' => $module,
                        "menus" => $module == "" ? $module : $module . "-4",
                        "contents" => [
                            [
                                "href" => "/admin/wechat_applet/setting",
                                "title" => "基础配置",
                                "icon" => 'fa fa-window-maximize',
                                "type" => 3,
                                "status" => 1,
                                "remark" => "基础配置",
                                "target" => "_self",
                                "createtime" => $time,
                                'module' => $module,
                                "menus" => $module == "" ? $module : $module . "-5",
                            ]
                        ],
                    ],
                ]
            ],
        ];
    }
}