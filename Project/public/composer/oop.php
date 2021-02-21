<?php

    abstract class AbPage {

        protected final function template() {
            $result  = $this->header();
            $result .= $this->article();
            $result .= $this->footer();
            return $result;
        }

        protected abstract function header();
        protected abstract function article();
        protected abstract function footer();

        public function render() {
            $result = "";
            $result .= $this->header();
            $result .= $this->article();
            $result .= $this->footer();

            return $result;
        }
    }

    class TextAbPage extends AbPage {
        protected function header() {
            return "PHP\n";
        }

        protected  function article() {
            return "PHP: 이수진 마스터\n";
        }

        protected  function footer() {
            return "Web is real\n";
        }
    }

    $text = new TextAbPage();
    echo $text->Render();

    class HtmlAbPage extends AbPage {
        protected  function header() {
            return "<header>PHP</header>";
        }

        protected  function article() {
            return "<article>PHP: 이수진 마스터</article>";
        }

        protected  function footer() {
            return "<footer>Web is real</footer>";
        }

        public function render() {
            $result = "<html>";
            $result .= $this->template();
            $result .= "</html>";

            return $result;
        }
    }

    $html = new HtmlAbPage();
    echo $html->Render();
