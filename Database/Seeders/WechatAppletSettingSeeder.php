<?php
namespace Modules\WechatApplet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @author liming
 * @date 2021-08-27
 */
class WechatAppletSettingSeeder extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('wechat_applet_setting')){
            $info = DB::table('wechat_applet_setting')->where('id', '>', 0)->first();
            if(!$info){
                $arr = $this->defaultInfo();
                if(!empty($arr) && is_array($arr)) {
                    $created_at = $updated_at = date("Y-m-d H:i:s");
                    foreach ($arr as $name => $item) {
                        DB::table('wechat_applet_setting')->insert([
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
                "group" => "base", "code" => "app_id", "title" => "小程序ID",
                "value" => "", "remark" => "", "sort" => 1,
            ],
            [
                "group" => "base", "code" => "app_secret", "title" => "小程序AppSecret",
                "value" => "", "remark" => "", "sort" => 2,
            ],
            [
                "group" => "base", "code" => "mch_id", "title" => "微信支付商户号",
                "value" => "", "remark" => "", "sort" => 3,
            ],
            [
                "group" => "base", "code" => "mch_key", "title" => "微信支付Api密钥",
                "value" => "", "remark" => "", "sort" => 4,
            ],
            [
                "group" => "base", "code" => "cert_pem", "title" => "微信支付apiclient_cert.pem",
                "value" => "", "remark" => "使用文本编辑器打开apiclient_cert.pem文件，将文件的全部内容复制进来", "sort" => 5,
            ],
            [
                "group" => "base", "code" => "key_pem", "title" => "微信支付apiclient_key.pem",
                "value" => "", "remark" => "使用文本编辑器打开apiclient_key.pem文件，将文件的全部内容复制进来", "sort" => 6,
            ],
        ];
    }
}