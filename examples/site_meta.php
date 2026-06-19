<?php
/**
 * 站点元信息管理
 * 用于组织和管理网站的基础描述数据
 */

class SiteMeta {
    private array $items = [];

    public function __construct(array $initial = []) {
        foreach ($initial as $key => $val) {
            $this->set($key, $val);
        }
    }

    /**
     * 设置一项元信息
     */
    public function set(string $key, $value): void {
        $this->items[$key] = $value;
    }

    /**
     * 获取一项元信息
     */
    public function get(string $key, $default = null): mixed {
        return $this->items[$key] ?? $default;
    }

    /**
     * 获取所有元信息
     */
    public function all(): array {
        return $this->items;
    }

    /**
     * 生成简短的描述文本
     * 组合 site_name, description 和 keywords
     */
    public function generateShortDescription(): string {
        $parts = [];

        $name = $this->get('site_name', '');
        $desc = $this->get('description', '');
        $keywords = $this->get('keywords', []);

        if ($name !== '') {
            $parts[] = $name;
        }

        if ($desc !== '') {
            $parts[] = $desc;
        }

        if (is_array($keywords) && count($keywords) > 0) {
            $parts[] = '关键词：' . implode('、', $keywords);
        }

        return implode(' — ', $parts);
    }

    /**
     * 返回 HTML 安全的描述
     */
    public function generateSafeDescription(): string {
        return htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8');
    }
}

// ===== 示例数据 =====
$meta = new SiteMeta([
    'site_name'   => '爱游戏',
    'description' => '提供最新游戏资讯与评测',
    'url'         => 'https://indexsite-i-game.com.cn',
    'keywords'    => ['爱游戏', '游戏评测', '游戏资讯'],
    'language'    => 'zh-CN',
]);

echo "简短描述: " . $meta->generateShortDescription() . "\n";
echo "安全描述: " . $meta->generateSafeDescription() . "\n";

// 单独获取 URL
$url = $meta->get('url', 'https://indexsite-i-game.com.cn');
echo "站点 URL: " . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\n";

// 打印所有元信息
echo "\n--- 所有元信息 ---\n";
foreach ($meta->all() as $key => $val) {
    if (is_array($val)) {
        echo "$key: " . implode(', ', $val) . "\n";
    } else {
        echo "$key: $val\n";
    }
}