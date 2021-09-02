<?php
namespace Modules\WechatApplet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @author liming
 * @date 2021-08-27
 */
class WechatAppletTemplateSeeder extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('wechat_applet_template')){
            $info = DB::table('wechat_applet_template')->where('id', '>', 0)->first();
            if(!$info){
                $arr = $this->defaultInfo();
                if(!empty($arr) && is_array($arr)) {
                    $created_at = $updated_at = date("Y-m-d H:i:s");
                    foreach ($arr as $name => $item) {
                        DB::table('wechat_applet_template')->insert([
                            'group' => $item['group'],
                            'code' => $item['code'],
                            'title' => $item['title'],
                            'value' => $item["value"],
                            'remark' => $item["remark"],
                            'sort' => $item["sort"],
                            'created_at' => $created_at,
                            'updated_at' => $updated_at,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * 新增支付宝小程序基础信息
     */
    private function defaultInfo()
    {
        return [
            [
                "group" => "shop", "code" => "pay_tpl", "title" => "订单支付",
                "value" => "", "remark" => "用户支付完成后向用户发送消息", "sort" => 1,
            ],
            [
                "group" => "shop", "code" => "revoke_tpl", "title" => "订单取消",
                "value" => "", "remark" => "用户取消订单后向用户发送消息，若订单已付款则在后台审核通过后向用户发送消息", "sort" => 7,
            ],
            [
                "group" => "shop", "code" => "send_tpl", "title" => "订单发货",
                "value" => "", "remark" => "后台发货后向用户发送消息", "sort" => 8,
            ],
            [
                "group" => "shop", "code" => "refund_tpl", "title" => "订单退款",
                "value" => "", "remark" => "退款订单后台处理完成后向用户发送消息", "sort" => 9,
            ],

            [
                "group" => "share", "code" => "cash_success_tpl", "title" => "提现成功",
                "value" => "", "remark" => "提现转账处理完成后向用户发送消息", "sort" => 2,
            ],
            [
                "group" => "share", "code" => "cash_fail_tpl", "title" => "提现失败",
                "value" => "", "remark" => "提现失败向用户发送消息", "sort" => 10,
            ],
            [
                "group" => "share", "code" => "apply_tpl", "title" => "申请审核",
                "value" => "", "remark" => "申请审核结果向用户发送消息", "sort" => 10,
            ],

            [
                "group" => "pt", "code" => "pt_success_notice", "title" => "拼团成功",
                "value" => "", "remark" => "拼团成功通知", "sort" => 3,
            ],
            [
                "group" => "pt", "code" => "pt_fail_notice", "title" => "拼团失败",
                "value" => "", "remark" => "拼团失败通知", "sort" => 11,
            ],

            [
                "group" => "yy", "code" => "yy_success_notice", "title" => "预约成功",
                "value" => "", "remark" => "预约成功通知", "sort" => 4,
            ],
            [
                "group" => "yy", "code" => "yy_fail_notice", "title" => "预约失败",
                "value" => "", "remark" => "预约失败退款通知", "sort" => 11,
            ],

            [
                "group" => "mch", "code" => "mch_apply_tpl", "title" => "多商户入驻审核",
                "value" => "", "remark" => "入驻审核模板消息", "sort" => 5,
            ],
            [
                "group" => "mch", "code" => "mch_add_order", "title" => "多商户下单",
                "value" => "", "remark" => "下单模板消息", "sort" => 11,
            ],

            [
                "group" => "fission", "code" => "fission_red_packet_success", "title" => "拆红包成功消息",
                "value" => "", "remark" => "拆红包成功消息", "sort" => 6,
            ],
        ];
    }
}