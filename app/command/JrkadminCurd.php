<?php
// +----------------------------------------------------------------------
// | Created by PHPstorm: [ JRK丶Admin ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2022 [LuckyHHY] All rights reserved.
// +----------------------------------------------------------------------
// | SiteUrl: http://www.luckyhhy.cn
// +----------------------------------------------------------------------
// | Author: LuckyHhy <jackhhy520@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/8/14 0014
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
namespace app\command;
use Jrk\Tool;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class JrkadminCurd extends Command
{
    protected $appPath;

    public function __construct()
    {
        parent::__construct();
        $this->appPath = base_path();
    }

    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:配置
     */
    protected function configure()
    {
        $this->setName('make:jrkadmin_curd')
            ->addArgument('controller', Argument::OPTIONAL, "controller name")
            ->addArgument('model', Argument::OPTIONAL, "model name")
            ->addArgument('validate', Argument::OPTIONAL, "validate name")
            ->addOption('app', null, Option::VALUE_REQUIRED, 'app name')
            ->setDescription('Create curd option controller model --app?');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:执行
     */
    protected function execute(Input $input, Output $output)
    {
        $appName = 'admin';
        $controllerName = trim($input->getArgument('controller'));
        if (!$controllerName) {
            $output->writeln('Controller Name Must Set');exit;
        }
        $modelName = trim($input->getArgument('model'));
        if (!$modelName) {
            $output->writeln('Model Name Must Set');exit;
        }
        $validateName = trim($input->getArgument('validate'));
        if ($appName!="common"){
            if (!$validateName) {
                $output->writeln('Validate Name Must Set');exit;
            }
        }

        if ($input->hasOption('app')) {
            $appName = $input->getOption('app');
        }
        $this->makeController($controllerName,$modelName, $appName);
        $output->writeln($controllerName . ' controller create success');
        $this->makeModel($modelName, $appName);
        $output->writeln($appName . ' model create success');

        if ($appName!="common"){
            $this->makeValidate($validateName, $appName);
            $output->writeln($validateName . ' validate create success');

            $this->makeView($controllerName, $appName);
            $output->writeln($appName . ' view create success');
        }

    }

    /**
     * @param $controllerName
     * @param $modelName
     * @param $appName
     * @return bool|int
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:创建控制器文件
     */
    protected function makeController($controllerName,$modelName, $appName)
    {
        $controllerKpl = $this->appPath . 'command' . DIRECTORY_SEPARATOR . 'temp' .DIRECTORY_SEPARATOR. 'Controller.kpl';
        $date=date("Y-m-d H:i:s",time());

        $controllerKpl = str_replace(['$controller', '$app','$modelName','$date'], [ucfirst($controllerName), strtolower($appName),ucfirst($modelName),$date], file_get_contents($controllerKpl));

        /* if (stripos($controllerName,"."))*/
        $controllerPath = $this->appPath . $appName . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR;
        if (!is_dir($controllerPath)) {
            @mkdir($controllerPath, 0777, true);
        }
        return @file_put_contents( $controllerPath . $controllerName . '.php', $controllerKpl);
    }

    /**
     * @param $modelName
     * @param $appName
     * @return bool|int
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:创建模型文件
     */
    public function makeModel($modelName, $appName)
    {
        $modelKpl = $this->appPath .  'command' . DIRECTORY_SEPARATOR . 'temp' .DIRECTORY_SEPARATOR. 'Model.kpl';
        $modelPath = $this->appPath . $appName . DIRECTORY_SEPARATOR . 'model';
        if (!is_dir($modelPath)) {
            @mkdir($modelPath, 0777, true);
        }
        $date=date("Y-m-d H:i:s",time());
        $modelKpl = str_replace(['$model', '$app','$date'], [ucfirst($modelName), strtolower($appName),$date], file_get_contents($modelKpl));
        return @file_put_contents($modelPath . DIRECTORY_SEPARATOR . $modelName . '.php', $modelKpl);
    }

    /**
     * @param $validateName
     * @param $appName
     * @return bool|int
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:创建验证器
     */
    public function makeValidate($validateName, $appName)
    {
        $validateKpl = $this->appPath .  'command' . DIRECTORY_SEPARATOR . 'temp' .DIRECTORY_SEPARATOR. 'Validate.kpl';
        $validatePath = $this->appPath . $appName . DIRECTORY_SEPARATOR . 'validate';
        if (!is_dir($validatePath)) {
            @mkdir($validatePath, 0777, true);
        }
        $date=date("Y-m-d H:i:s",time());
        $validateKpl = str_replace(['$validate', '$app','$date'], [ucfirst($validateName), strtolower($appName),$date], file_get_contents($validateKpl));
        return @file_put_contents($validatePath . DIRECTORY_SEPARATOR . "Check".$validateName . '.php', $validateKpl);
    }


    /**
     * @param $controllerName
     * @param $appName
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:创建视图
     */
    public function makeView($controllerName, $appName)
    {
        $viewKpl = $this->appPath .  'command' . DIRECTORY_SEPARATOR . 'temp' .DIRECTORY_SEPARATOR. 'View.kpl';
        $controllerName=Tool::humpToLine($controllerName);
        $viewPath  = $this->appPath . $appName . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . strtolower($controllerName);
        if (!is_dir($viewPath)) {
            @mkdir($viewPath, 0777, true);
        }
        $viewKpl = str_replace(['$controllerName'], [ucfirst($controllerName)], file_get_contents($viewKpl));
        return @file_put_contents($viewPath . DIRECTORY_SEPARATOR .'index.html', $viewKpl);
    }

}