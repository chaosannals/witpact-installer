<?php namespace WitPact\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * WitPact 的 Composer 插件
 * 
 */
final class Plugin implements PluginInterface {
    /**
     * 插件生效，加载主题和插件安装器。
     * 
     */
    public function activate(Composer $composer, IOInterface $io) {
        $manager = $composer->getInstallationManager();
        $manager->addInstaller(new Creator($io, $composer));
        $manager->addInstaller(new Installer($io, $composer, 'witpact-theme'));
        $manager->addInstaller(new Installer($io, $composer, 'witpact-plugin'));
    }
}