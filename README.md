# Pure
由于之前的两个主题 Simple Way 跟 Simple Red 并不足够 **Simple**，所以再次开坑（其实前两个坑还没填完），Pure 完全为阅读而生，功能上会精简再精简。希望重度洁癖患者能够喜欢。

## 功能

### 支持 WordPress 多个自定义项目

1. 主题自定义
   1. 站点 Favicon 与站点图标自定义
   1. 背景图像与背景颜色以及顶部图像自定义
   1. 菜单自定义（目前只支持以及菜单） 
1. 文章特色图片（支持自动提取第一张图为特色图片）
1. 多文章类型并添加样式优化
   - aside
   - gallery
   - link
   - image
   - quote
   - status
   - video
   - audio
   - chart
### SEO 优化良好支持
1. 可自定义首页关键词与描述
2. 标签页面获取关键词为 Tag，页面描述为 Tag 描述
3. 分类页面获取分类描述为页面描述
4. 文章页面关键词为 Tag，页面描述截取自文章摘要

###  移动端展示优化

### AMP 支持（进行中）

### 支持引入内嵌或者引入外部代码
1. 支持添加自定义代码，如统计代码等
1. 支持内页添加广告代码

### 文章页面
1. 支持自动生成文章大纲
2. 支持代码高亮

### 页面模板支持
1. 文档归档页面
2. 友情链接页面
3. Tag 归档页面

## 优势

### 优化中文排版
1. 基于 typo.css
2. 基于 font.css

### 极致性能

- 优化关键渲染路径阻塞，lighthouse 100 分！
   1. CSS inline 以及压缩
   2. JavaScript 压缩以及底部引用
   3. 文章图片支持 lazyload
   4. 优化头图载入速度，基于 `prefetch` 
- <s>使用 公共前端 CDN 库</s>
- 去除无效 WordPress 资源加载
   - 去除 WordPress Emoji 😭
   - 去除 wp-embed.js 引用（已经整合到页面 main.js 中）
- <s>添加 Gavatar 本地存储，便于使用本地 CDN</s>
- 替换 Gavatar 使用 V2EX Gavatar CDN 加速国内访问速度
- 基于 Workbox 的 PWA 优化

> **建议配合 WP Super Cache、Memcached、PageSpeed Module 与 CDN 使用。**

### PWA 支持

1. 支持生成 `manifest.json`
2. 引入 Workbox 启用离线缓存（修改离线规则需重新打包）
   1. Google Analytics 
   2. Gavatar/ V2EX 头像服务

## 如何使用


## 致谢

感谢如下开源项目！

1. [normalize.css](https://github.com/necolas/normalize.css)
2. [typo](https://typo.sofi.sh/)
3. <s>jQuery</s>
4. <s>[jquery_lazyload](https://github.com/tuupola/jquery_lazyload)</s>
5. [PrismJS](http://prismjs.com)
6. [WordPress]()
