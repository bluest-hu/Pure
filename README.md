# Pure
由于之前的两个主题 Simple Way 跟 Simple Red并不足够 Simple ,所以再次开坑（其实前两个坑还没填完），Pure 完全为阅读而生，功能上会精简再精简。希望重度洁癖患者能够喜欢。

## 功能

1. 支持 WordPress 多个自定义项目
   1. 多文章类型
   2. 站点 Favicon 与 博客 Logo 自定义
   3. 背景图像与顶部图像自定义
   4. 文章特色图片
2. SEO优化
   1. 可自定义首页关键词与描述
   2. 标签页面获取关键词为 tag，描述为 tag 描述
   3. 分类页面获取分类描述
3. 移动端展示优化
4. 支持添加自定义代码，如统计代码等
5. 支持内页添加广告代码

## 特点

### 轻量



- 优化 JavaScript 与 CSS 引入，优化关键渲染路径阻塞。lighthouse 100 分！
- 文章图片支持 lazyload。
- <s>使用 公共前端 CDN 库</s>
- 去除无效 WordPress 资源加载
   - 去除 WordPress Emoji😭
- <s>添加 Gavatar 本地存储，便于使用本地 CDN</s>
- 替换 Gavatar 使用 V2EX Gavatar CDN 加速国内访问速度

> **建议配合 WP Super Cache、Memcached、PageSpeed Module 与 CDN 使用。**

### PWA 支持

1. 支持生成 `manifest.json`
2. 引入 Workbox 启用离线缓存，添加新的离线规则需要
   1. Google Analytics 
   2. Gavatar/ V2EX 头像服务

## 致谢

感谢如下开源项目！

1. [normalize.css](https://github.com/necolas/normalize.css)
2. [typo](https://typo.sofi.sh/)
3. <s>jQuery</s>
4. <s>[jquery_lazyload](https://github.com/tuupola/jquery_lazyload)</s>
5. [PrismJS](http://prismjs.com)
6. [WordPress]()
