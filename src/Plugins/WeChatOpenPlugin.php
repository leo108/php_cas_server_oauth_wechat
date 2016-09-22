<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2016/9/22
 * Time: 10:53
 */

namespace Leo108\CASServer\OAuth\WeChat\Plugins;

use Leo108\CASServer\OAuth\OAuthUser;
use Leo108\CASServer\OAuth\Plugin;
use Overtrue\Socialite\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WeChatOpenPlugin
 * @package Leo108\CASServer\OAuth\Wechat\Plugins
 */
class WeChatOpenPlugin extends Plugin
{
    /**
     * WeChatOpenPlugin constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'wechat_open_id',
            '',
            [
                'cn' => '微信(开放平台)',
                'en' => 'WeChat(Open Platform)',
            ]
        );
    }

    /**
     * @param Request $request
     * @param string  $callback
     * @return RedirectResponse
     */
    public function gotoAuthUrl(Request $request, $callback)
    {
        return app('cas.server.wechat.open')->oauth->setRequest($request)->redirect($callback);
    }

    /**
     * @param Request $request
     * @return OAuthUser
     */
    public function getOAuthUser(Request $request)
    {
        /* @var User $user */
        $user      = app('cas.server.wechat.open')->oauth->setRequest($request)->user();
        $oauthUser = new OAuthUser();
        $oauthUser->setId($user->getId())
            ->setName($user->getName())
            ->setAvatar($user->getAvatar())
            ->setOriginal($user->getOriginal())
            ->setToken($user->getToken()->getToken())
            ->addBind($this->fieldName, $user->getId());

        if (isset($user->getOriginal()['unionid'])) {
            $oauthUser->addBind('wechat_union_id', $user->getOriginal()['unionid']);
        }

        return $oauthUser;
    }
}
