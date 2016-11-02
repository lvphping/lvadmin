<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class LoginController extends BaseController{
     public function login(){
     	 if(IS_POST){
	     	$data=I('post.');
	     	$map['password']=md5($data['password']);
            $user=M('Users')->where($map)->find();
	        if (geetest_chcek_verify($data)) {
		        if (empty($user)) {
	                $this->ajaxReturn(array('code'=>'-2','message'=>'账号或密码错误'),'json');
	            }else{
	            	/*存进session*/
	            	$_SESSION['user']=array(
	                    'id'=>$user['id'],
	                    'username'=>$user['username'],
	                    'avatar'=>$user['avatar']
                    );
	            	$this->ajaxReturn(array('code'=>'1','message'=>'登陆成功'),'json');
	            }
	        }else{
	            $this->ajaxReturn(array('code'=>'-1','message'=>'验证码错误'),'json');
	        }
	        die;
     	 }
         $this->display();	
     }
    /**
     * geetest生成验证码
     */
    public function geetest_show_verify(){
        $geetest_id=C('GEETEST_ID');
        $geetest_key=C('GEETEST_KEY');
        $geetest=new \Org\Xb\Geetest($geetest_id,$geetest_key);
        $user_id = "test";
        $status = $geetest->pre_process($user_id);
        $_SESSION['geetest']=array(
            'gtserver'=>$status,
            'user_id'=>$user_id
            );
        echo $geetest->get_response_str();
    }
    /*
     * 退出登录
     * */
   public function logout(){
        session('user',null);
        $this->success('退出成功、前往登录页面',U('Admin/Login/login'));
    }



}
