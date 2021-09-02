<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWechatAppletSettingTable extends Migration
{
    public $tableName = "wechat_applet_setting";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->tableName)) $this->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }

    /**
     * 执行创建表
     */
    private function create()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';      // 设置存储引擎
            $table->charset = 'utf8';       // 设置字符集
            $table->collation  = 'utf8_general_ci';       // 设置排序规则

            $table->id();
            $table->string("group", 100)->nullable(false)->comment("微信小程序设置组名")->index("group_index");
            $table->string('code', 100)->nullable(false)->comment("微信小程序设置唯一标识")->unique("code_index");
            $table->string("title", 100)->nullable(false)->comment("微信小程序设置标题");
            $table->longText("value")->nullable(false)->comment("微信小程序设置内容");
            $table->string("remark")->nullable(false)->default("")->comment("微信小程序设置注释");
            $table->unsignedTinyInteger("sort")->nullable(false)->default(100)->comment("排序: 升序");
            $table->timestamps();
        });
        $prefix = DB::getConfig('prefix');
        $qu = "ALTER TABLE " . $prefix . $this->tableName . " comment '微信小程序设置表'";
        DB::statement($qu);
    }
}
