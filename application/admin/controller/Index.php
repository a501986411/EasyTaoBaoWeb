<?php
    namespace app\admin\controller;
    use think\Db;
    class Index extends App
    {

        public function index()
        {
            $this->redirect(url('/Left/left'));
            return view();
        }

        public function createIndex()
        {
            return view();
        }

    }
