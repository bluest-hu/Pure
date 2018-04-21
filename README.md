# Pure
由于之前的两个主题 Simple Way 跟 Simple Red并不足够 Simple ,所以再次开坑（其实前两个坑还没填完），Pure 完全为阅读而生，功能上会精简再精简。希望重度洁癖患者能够喜欢。

## 功能

1. 支持 WordPress 多个自定义项目
   1. 文章类型
   2. 站点 Favicon
   3. 背景图像与顶部图像
   4. 博客 Logo
2. SEO优化
   1. 可自定义首页关键词与描述
   2. tag 页面获取 关键词为 tag，描述为 tag 描述
   3. 分类页面获取 分类描述
3. 移动端展示优化
4. 支持添加自定义代码，如统计代码等

## 特点

### 轻量

建议配合  WP Super Cache 、memcached 与 CDN 使用。

1. 优化 JavaScript 与 CSS 引入，降低首屏展示阻塞。
2. 文章图片支持 lazyload。
3. 使用 公共前端 CDN 库
4. 去除无效 WordPress 资源加载
   1. 去除 WordPress emoji



## 致谢

感谢如下开源项目！

1. [normalize.css](https://github.com/necolas/normalize.css)
2. [typo](https://typo.sofi.sh/)
3. jQuery
4. [jquery_lazyload](https://github.com/tuupola/jquery_lazyload)
5. [PrismJS](http://prismjs.com)
6. [WordPress]()