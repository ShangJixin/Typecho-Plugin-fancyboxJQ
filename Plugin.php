<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 用 jQuery 的方式给站点引入 fancybox 灯箱
 * 
 * @package fancyboxJQ
 * @author 尚寂新
 * @version 1.1.1
 * @link https://github.com/ShangJixin
 */
class fancyboxJQ_Plugin implements Typecho_Plugin_Interface
{
     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        
        $selector = new Typecho_Widget_Helper_Form_Element_Text('selector', NULL, 'body', _t('jQuery 选择器'));
        $form->addInput($selector);
        
        $needjq = new Typecho_Widget_Helper_Form_Element_Checkbox('needjq', array('yes' => _t('引用')), array('yes'), _t('是否加载jquery.min.js'));
        $form->addInput($needjq);
        
        echo '<h2>插件使用说明</h2><p>jQuery 选择器：默认为<code>body</code>，但方法过于粗暴。请根据您主题的情况，使选择器更精准的选择到你文章输出的位置上所包裹的HTML标签！</p><p>是否加载 jQuery：为了防止重复引用 jQuery，给站点带来不必要的加载开销，所以设置此功能。如果你已经在主题内或者是其他插件已经加载过 jQuery，那就无需再次加载。</p><p><strong>注：fancyboxJQ 相关资源引入依赖于 jsdelivr CDN</strong></p>';

    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}


    /**
     * 为header添加css文件
     * 
     * @return void
     */
    public static function header() {
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />';
    }

    /**
     * 为footer添加js文件
     * 
     * @return void
     */
    public static function footer() {
        
        if(Helper::options()->plugin('fancyboxJQ')->needjq){
            echo '<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>';
        }
        echo '<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>';
        
        $selector = Helper::options()->plugin('fancyboxJQ')->selector;
        echo '<script>$(document).ready(function(){$("'.$selector.' img").each(function(){var _a = $("<a></a>").attr({"href":this.src,"data-fancybox":"gallery","no-pjax":"","data-type":"image","data-caption":this.alt});$(this).wrap(_a);});});</script>';

    }
}
