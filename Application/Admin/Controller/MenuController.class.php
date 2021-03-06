<?php
//后台菜单相关
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController{
	public function add(){
		if($_POST){			
			if(!isset($_POST['name']) || !$_POST['name']){
				return show(0,'菜单名不能为空');
			}
			if(!isset($_POST['m']) || !$_POST['m']){
				return show(0,'模块名不能为空');
			}
			if(!isset($_POST['c']) || !$_POST['c']){
				return show(0,'控制器名不能为空');

			}	
			if(!isset($_POST['f']) || !$_POST['f']){
				return show(0,'方法名不能为空');
			}	

			if($_POST['menu_id']){
				return $this->save($_POST);
			}
			$menuId = D("Menu")->insert($_POST);
			if($menuId){
				return show(1,'新增成功',$menuId);
			}
			return show(0,'新增失败',$menuId);

		}else{
			$this->display();
		}
	}

	public function index(){
		$data = array();
		if(isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1))){
			$data['type']= intval($_REQUEST['type']);
			$this->assign('type',$data['type']);
		}else{
			$this->assign('type',-100);
		}


		//分页操作逻辑
		$page=$_REQUEST['p'] ? $_REQUEST['p'] : 1;
		$pageSize=$_REQUEST['page'] ? $_REQUEST['page'] : 10;
		$menus = D('Menu')->getMenus($data,$page,$pageSize);
		$menusCount =D('Menu')->getMenusCount($data);

		$res=new \Think\Page($menusCount,$pageSize);
		$pageRes = $res->show();
		$this->assign('pageRes',$pageRes);
		$this->assign('menus',$menus);
		$this->display();
	}

	public function edit(){
		$menuID = $_GET['id'];

		$menu = D("Menu")->find($menuID);
		$this->assign('menu',$menu);
		$this->display();
	}

	public function save($data){
		$menuID = $data['menu_id'];
		unset($data['menu_id']);

		try{
			$id= D('Menu')->updateMenuById($menuID,$data);
			if($id=== false){
				return show(0,'更新失败');
			}
			return show(1,'更新成功');
		}catch(Exception $e){
			return show(0,$e->getMessage());
		}	
	}
}
























