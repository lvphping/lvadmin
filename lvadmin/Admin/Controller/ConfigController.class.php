<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台首页控制器
 */
class ConfigController extends AdminBaseController{
	/**
	 * 首页
	 */ 
	public function index(){
		if(isset($_GET['conf']) && $_GET['conf'] == 'do'){
			echo "aaa";
			exit();
		}else{
			  if($_POST){
				    //读取配置文件，并替换真实配置数据
				    $filestr = APP_PATH.'Common/conf/webconfig.php';
				    if(file_exists($filestr)){
				        $settingstr="<?php \n return array(\n";
						foreach($_POST as $key=>$v){
						    $settingstr.= "\t'".strtoupper($key)."'=>'".$v."',\n";
						}
						$settingstr.="\n);\n?>\n"; 
				        $result = file_put_contents($filestr,$settingstr);
				        if($result){
				        	$this->success('修改成功',U('index'));
				        }else{
				        	$this->success('修改失败',U('index'));
				        }
				    } 
			        die;
			 }
		}
		$this->display();
	}




}
