<?php
namespace atms\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of LinkPager
 *
 * @author liyunfang <381296986@qq.com>
 * @date 2015-09-07
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * {pageButtons} {customPage} {pageSize}
     */
    public $template = '<div class="form-inline">{pageSize}{pageButtons}</div>';

    /**
     * pageSize list
     */
    public $pageSizeList = [10, 15, 25, 35, 50, 100];

    /**
     *
     * Margin style for the  pageSize control
     */
    public $pageSizeMargin = [
        'margin-left' => '0px',
        'margin-right' => '0px',
    ];

    /**
     * customPage width
     */
    public $customPageWidth = 50;

    /**
     * Margin style for the  customPage control
     */
    public $customPageMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * Jump
     */
    public $customPageBefore = '';
    /**
     * Page
     */
    public $customPageAfter = '';

    /**
     * pageSize style
     */
    public $pageSizeOptions = [
        'class' => 'form-control per-page',

        'style' => [
            'display' => 'inline-block',
            'width' => 'auto',
            'margin-top' => '0px',
        ],
    ];

    /**
     * customPage style
     */
    public $customPageOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'margin-top' => '0px',
        ],
    ];

    /*
     * new option
     */

    public $pjaxSubmit = false;

    public function init()
    {
        parent::init();
        if ($this->pageSizeMargin) {
            Html::addCssStyle($this->pageSizeOptions, $this->pageSizeMargin);
        }
        if ($this->customPageWidth) {
            Html::addCssStyle($this->customPageOptions, 'width:' . $this->customPageWidth . 'px;');
        }
        if ($this->customPageMargin) {
            Html::addCssStyle($this->customPageOptions, $this->customPageMargin);
        }
    }


    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageContent();
    }

    protected function renderPageContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if ('customPage' == $name) {
                return $this->renderCustomPage();
            } else if ('pageSize' == $name) {
                return $this->renderPageSize();
            } else if ('pageButtons' == $name) {
                return $this->renderPageCustomButtons();
            }
            return '';
        }, $this->template);
    }

    protected function renderPageCustomButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageCustomButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageCustomButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageCustomButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageCustomButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageCustomButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param int $page the page number
     * @param string $class the CSS class for the page button.
     * @param bool $disabled whether this page button is disabled
     * @param bool $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageCustomButton($label, $page, $class, $disabled, $active)
    {

        $options = ['class' => empty($class) ? $this->pageCssClass : $class];


        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'span');

            return Html::tag('li', Html::tag($tag, $label, $this->disabledListItemSubTagOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        if ($this->pjaxSubmit)
        {
            $linkOptions['data'] = [
                'method'    => 'post',
                'params'    => [
                    'page'    =>  $page
                ]
            ];

            $linkOptions['data-pjax'] = 0;

        }


        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }


    protected function renderPageSize()
    {
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        //$linkurl =  $this->pagination->createUrl($page);


        if ($this->pjaxSubmit)
        {
           // $this->pageSizeOptions['data-pjax'] = 0;
            //$this->pageSizeOptions['data'] = [
              //  'method'    => 'get',
            //];

        }

        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    protected function renderCustomPage()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if (isset($params[$this->pagination->pageParam])) {
            $page = intval($params[$this->pagination->pageParam]);
            if ($page < 1) {
                $page = 1;
            } else if ($page > $pageCount) {
                $page = $pageCount;
            }
        }
        return $this->customPageBefore . Html::textInput($this->pagination->pageParam, $page, $this->customPageOptions) . $this->customPageAfter;
    }

}