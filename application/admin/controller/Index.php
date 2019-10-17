<?php
    namespace app\admin\controller;
    use think\Db;
    class Index extends App
    {

        public function index()
        {
            $this->redirect(url('/RouteService/index'));
            return view();
        }

        public function createIndex()
        {
            return view();
        }

    }
