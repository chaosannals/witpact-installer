<?php namespace WitPact\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\ProjectInstaller;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * 安装器
 * 
 */
class Creator extends ProjectInstaller {
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