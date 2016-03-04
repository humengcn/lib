<?php

class Pagination
{

    public $total = 0;  //消息总条数
    public $page = 1;    //当前页码
    public $limit = 20;  //一页显示多少条数据
    public $num_links = 10;  //
    public $url = '';  //a标签的href
    public $text = '共{total}条记录，第{page}/{pages}页';
    public $text_first = '|&lt;';  //跳转到第一页
    public $text_last = '&gt|';    //跳转到最后一页
    public $text_next = '&gt;';    //跳转到下一页
    public $text_prev = '&lt;';    //跳转到前一页 
    public $style_links = 'pagination'; //分页按钮外层wrap的class
    public $style_results = 'results'; //所有的分页按钮

    public function render()
    {
        $total = $this->total;  //总共多少条

        if ($this->page < 1) {
            $page = 1;  //如果页码小于1，则设置为1
        } else {
            $page = $this->page; //否则就是当前页码
        }

        if (!(int)$this->limit) { //如果没有设置每页条数，则为15
            $limit = 15;
        } else {
            $limit = $this->limit; //当前条数
        }

        // $this->url = $this->url; //url

        $num_links = $this->num_links;  //链接总数
        $num_pages = ceil($total / $limit);  //总共有多少页

        $output = ''; //输出

        if ($page > 1) { //如果页码大于1
            //最左边的页码设置为1
            $output .= ' <li><a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a></li> <li><a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li> ';
        }

        //总共有多少页
        if ($num_pages > 1) {
            if ($num_pages <= $num_links) {
                $start = 1;
                $end = $num_pages;
            } else {
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);

                if ($start < 1) {
                    $end += abs($start) + 1;
                    $start = 1;
                }

                if ($end > $num_pages) {
                    $start -= ($end - $num_pages);
                    $end = $num_pages;
                }
            }

            if ($start > 1) {
                $output .= ' .... ';
            }

            for ($i = $start; $i <= $end; $i++) {
                if ($page == $i) {
                    $output .= ' <li class="active"><a>' . $i . '</a></li> ';
                } else {
                    $output .= ' <li><a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a></li> ';
                }
            }

            if ($end < $num_pages) {
                $output .= ' .... ';
            }
        }

        if ($page < $num_pages) {
            $output .= ' <li><a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li> <li><a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li> ';
        }

        $find = array(
            '{total}',
            '{page}',
            '{pages}'
        );

        $replace = array(
            $total,
            $page,
            $num_pages
        );

        // $output = '<span>' . str_replace($find, $replace, $this->text) . '</span>' . $output;

        return '<ul class="' . $this->style_links . '">' . $output . '</ul>';
    }

}

?>