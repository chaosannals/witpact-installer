<?php namespace WitPact\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * 安装器
 * 
 */
class Installer extends LibraryInstaller {
    private const MAP = [
        'witpact-plugin' => 'type:wordpress-plugin',
        'witpact-theme' => 'type:wordpress-theme',
    ];

    /**
     * 匹配支持的类型。
     * 
     */
    public function supports($packageType) {
        return $this->type === $packageType;
    }

    /**
     * 安装。
     * 
     * @param InstalledRepositoryInterface $repository: 仓库。
     * @param PackageInterface $package: 安装包。
     */
    public function install(InstalledRepositoryInterface $repository, PackageInterface $package) {
        parent::install($repository, $package);
        $target = $this->getDistTargetDir($package);
        $source = $this->getDistSourceDir($package);
        $this->filesystem->copy($source, $target);
    }

    /**
     * 卸载。
     * 
     * @param InstalledRepositoryInterface $repository: 仓库。
     * @param PackageInterface $package: 卸载包。
     */
    public function uninstall(InstalledRepositoryInterface $repository, PackageInterface $package) {
        parent::install($repository, $package);
        $target = $this->getDistTargetDir($package);
        $this->filesystem->removeDirectory($target);
    }

    /**
     * 获取 WordPress 主题或插件安装路径。
     * 
     * @param PackageInterface $package: 包。
     * @return string: 安装路径。
     */
    protected function getDistTargetDir(PackageInterface $package) {
        $packageExtra = $package->getExtra();
        $projectExtra = $this->composer->getPackage()->getExtra();
        $name = $packageExtra['witpact-alias'] ?? $package->getName();
        foreach ($projectExtra['installer-paths'] as $path => $names) {
            if (in_array(self::MAP[$this->type], $names)) {
                return str_replace('{$name}', $name, $path);
            }
        }
        return false;
    }

    /**
     * 获取 WordPress 主题或插件源路径。
     * 
     * @param PackageInterface $package: 包。
     * @return string: 源路径。
     */
    protected function getDistSourceDir($package) {
        $extra = $package->getExtra();
        $directory = $this->getInstallPath($package);
        return $directory.DIRECTORY_SEPARATOR.$extra['witpact-dist-dir'];
    }
}