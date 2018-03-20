<?php namespace WitPact\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * 安装器
 * 
 */
class ProjectInstaller extends LibraryInstaller {
    /**
     * 匹配支持的类型。
     * 
     */
    public function supports($packageType) {
        return 'project' === $packageType;
    }

    /**
     * 安装。
     * 
     * @param InstalledRepositoryInterface $repository: 仓库。
     * @param PackageInterface $package: 安装包。
     */
    public function install(InstalledRepositoryInterface $repository, PackageInterface $package) {
        parent::install($repository, $package);
        $this->filesystem->copy('access', 'public');
        $this->filesystem->removeDirectory('access');
    }
}