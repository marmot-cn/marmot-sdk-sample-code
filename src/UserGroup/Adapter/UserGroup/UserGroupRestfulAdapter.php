<?php
namespace Sdk\UserGroup\Adapter\UserGroup;

use Marmot\Core;
use Marmot\Framework\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\UserGroup\Model\NullUserGroup;
use Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class UserGroupRestfulAdapter extends GuzzleAdapter implements IUserGroupAdapter
{
    use AsyncFetchAbleRestfulAdapterTrait, FetchAbleRestfulAdapterTrait;

    private $translator;
    private $resource;

    const SCENARIOS = [
        'USERGROUP_LIST'=>[
            'fields'=>['userGroups'=>'id,name,updateTime,status']
        ],
        'USERGROUP_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];
    
    public function __construct()
    {
        parent::__construct(
            Core::$container->get('services.backend.url')
        );
        $this->translator = new UserGroupRestfulTranslator();
        $this->scenario = array();
        $this->resource = 'userGroups';
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, new NullUserGroup());
    }
}
