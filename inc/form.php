<div class="wrap">
  <h2>主题选项</h2>
  <form method="post" action="">
    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row">首页关键词添加</th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span>首页关键词添加</span>
              </legend>
              <p>
                <label for="indexKeywords"
                       class="description">
                  添加在首页关键词，请用<code>,</code>间隔
                </label>
              </p>
              <textarea name="index_page_keywords" 
                        class="large-text code" 
                        id="indexKeywords" 
                        rows="3" 
                        cols="30" 
                        style="text-indent:0;padding:0"><?php echo stripslashes(trim(get_option('pure_theme_index_page_keywords'))); ?>
              </textarea>
              <p class="description">
                建议设置 2~3 个，最多不超过 5 个
              </p>
            </fieldset>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">首页描述添加</th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span>首页描述添加</span>
              </legend>
              <p>
                <label for="indexDescription" class="description">
                  添加首页描述
                </label>
              </p>
              <textarea name="index_page_description" 
                        class="large-text code" 
                        id="indexDescription" 
                        rows="3" 
                        cols="30" 
                        style="text-indent:0;padding:0"><?php echo stripslashes(trim(get_option('pure_theme_index_page_description'))); ?>
              </textarea>
              <p class="description">
                在Google的搜索结果中，摘要信息标题长度一般在 72 字节（即 36 个中文字）左右，而百度则只有 56 字节（即 28 个中文字）左右，超出这个范围的内容将被省略。
              </p>
            </fieldset>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">统计代码添加</th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span>统计代码添加</span>
              </legend>
              <p>
                <label for="analytics" class="description">
                  在主题底部添加统计代码或者分享代码等（请包含 <code>&lt;script&gt;&lt;/script&gt;</code>标签 ）
                </label>
              </p>
              <textarea name="analytics" class="large-text code" id="analytics" rows="10" cols="50" style="text-indent:0;padding:0"><?php echo stripslashes(trim(get_option('pure_theme_analytics'))); ?></textarea>
            </fieldset>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">文章页面的分享代码/相关文章</th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span>统计代码添加</span>
              </legend>
              <p>
                <label for="single_script">
                  在文章主题底部添加统计代码或者分享代码等（请包含 <code>&lt;script&gt;&lt;/script&gt;</code>标签 ）
                </label>
              </p>
              <textarea name="single_script" class="large-text code" id="single_script" rows="10" cols="50" style="text-indent:0;padding:0"><?php echo stripslashes(trim(get_option('pure_theme_single_script'))); ?></textarea>
              <p class="description">
                请注意该段代码只会在文章页面出现
              </p>
            </fieldset>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">文章页面的广告</th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span>统计代码添加</span>
              </legend>
              <p>
                <label for="single_script">
                  在文章主题内页添加广告（请包含 <code>&lt;script&gt;&lt;/script&gt;</code>标签 ）
                </label>
              </p>
              <textarea name="single_ads_script" class="large-text code" id="single_script" rows="10" cols="50" style="text-indent:0;padding:0"><?php echo stripslashes(trim(get_option('pure_theme_single_ads_script'))); ?></textarea>
              <p class="description">
                请注意该段代码只会在文章页面出现
              </p>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="保存设置" />
      <input type="hidden" name="pure_theme_settings" value="save" style="display:none;" />
    </p>
  </form>
  <form action="">
  </form>
</div>
