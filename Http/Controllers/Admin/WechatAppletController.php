<?php
// @author liming
namespace Modules\WechatApplet\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Modules\WechatApplet\Entities\WechatAppletSetting;
use Modules\WechatApplet\Entities\WechatAppletTemplate;
use Modules\WechatApplet\Http\Requests\Admin\WechatAppletSettingRequest;
use Modules\WechatApplet\Http\Requests\Admin\WechatAppletTemplateRequest;
use Modules\WechatApplet\Http\Controllers\Controller;

class WechatAppletController extends Controller
{
    /**
     * 微信小程序基础配置
     */
    public function setting(WechatAppletSettingRequest $request)
    {
        if($request->isMethod('post')) {
            $request->check();
            $data = $request->post("data");
            if(!is_array($data)) return $this->failed('参数错误');

            DB::beginTransaction();
            try {
                foreach ($data as $item){
                    $code = $item['code'] ?? "";
                    $info = WechatAppletSetting::where("code", $code)->first();
                    if(!$info) throw new \Exception("小程序配置参数不存在");
                    $info->value = $item['value'] ?? "";
                    if(!$info->save()) throw new \Exception("操作失败：" . $info->title . "修改失败");
                }
                DB::commit();
                return $this->success();
            }catch (\Exception $e){
                DB::rollBack();
                return $this->failed($e->getMessage());
            }
        } else {
            $title = "基础设置";
            $list = WechatAppletSetting::orderBy("group")->orderBy("sort")->get();
            return view('wechatappletview::admin.wechat_applet.setting', compact('title', "list"));
        }
    }

    /**
     * 微信小程序模板消息设置
     */
    public function template(WechatAppletTemplateRequest $request)
    {
        if($request->isMethod('post')) {
            $request->check();
            $data = $request->post();
            DB::beginTransaction();
            try {
                foreach ($data as $code => $value){
                    $info = WechatAppletTemplate::where("code", $code)->first();
                    if(!$info) throw new \Exception("小程序模板标识不存在");
                    $info->value = $value ?? "";
                    if(!$info->save()) throw new \Exception("操作失败：" . $info->title . "修改失败");
                }
                DB::commit();
                return $this->success();
            }catch (\Exception $e){
                DB::rollBack();
                return $this->failed($e->getMessage());
            }
        } else {
            $title = "模板消息";
            $list = WechatAppletTemplate::getGroupArr();
            foreach ($list as &$item){
                $item["data"] = WechatAppletTemplate::where("group", $item["name"])->orderBy("sort")->get()->toArray();
            }
            return view('wechatappletview::admin.wechat_applet.template', compact('title', "list"));
        }
    }
}
