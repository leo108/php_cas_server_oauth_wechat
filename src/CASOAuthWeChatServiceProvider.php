<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2016/9/22
 * Time: 11:06
 */

namespace Leo108\CASServer\OAuth\WeChat;

use EasyWeChat\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Leo108\CASServer\OAuth\PluginCenter;
use Leo108\CASServer\OAuth\WeChat\Plugins\WeChatOpenPlugin;
use Leo108\CASServer\OAuth\WeChat\Plugins\WeChatMpPlugin;

class CASOAuthWeChatServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!$this->app->bound(PluginCenter::class)) {
            $this->app->singleton(PluginCenter::class);
        }
        $pluginCenter = $this->app->make(PluginCenter::class);

        if ($this->checkBound('cas.server.wechat.mp', Application::class)) {
            $pluginCenter->register($this->app->make(WeChatMpPlugin::class));
        }

        if ($this->checkBound('cas.server.wechat.open', Application::class)) {
            $pluginCenter->register($this->app->make(WeChatOpenPlugin::class));
        }
    }

    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/../database/migrations/' => database_path('migrations'),
            ],
            'migrations'
        );
    }

    /**
     * @param string $name
     * @param string $class
     * @return bool
     */
    protected function checkBound($name, $class)
    {
        if (!$this->app->bound($name)) {
            return false;
        }

        $instance = $this->app->make($name);

        return $instance instanceof $class;
    }
}
