<?php namespace WitPact\Composer;

use Composer\Script\Event;
use Composer\Util\Filesystem;

/**
 * 构建器
 * 
 * 创建 WitPact 项目时起到安装作用。
 */
final class Builder {
    /**
     * 构建项目。
     * 
     * @param Event $event: 事件。
     */
    public function build(Event $event) {
        $io = $event->getIO();
        $composer = $event->getComposer();

        // 拷贝和清理目录结构
        $io->write('copy asset start...');
        $filesystem = new Filesystem;
        $filesystem->copy('asset', 'public');
        $filesystem->remove('asset');
        $io->write('copy asset end.');
    }
}