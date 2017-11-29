<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup;
use Gost\Bundle\SiteManagerBundle\Form\FuncgroupForm;
use Gost\Bundle\SiteManagerBundle\Entity\MFunc;
use Gost\Bundle\SiteManagerBundle\Entity\MPermission;
use Gost\Bundle\SiteManagerBundle\Entity\MRole;

/**
 *
 * @author devylee
 *        
 */
class FunctionController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'sys_functions';
	}
	

	/**
	 * 功能组列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function groupsAction() {
		$request = $this->getRequest();
		$groups = $this->get('gost_site_manager.permission_service')->getFuncGroups();
		return $this->smartRender('GostSiteManagerBundle:Function:groups.html.twig', '系统功能设置', array(
				'tab_id' => $this->getCurrentFunc(),
				'groups' => $groups
	
		));
	}
	
	/**
	 * 登记/修改/删除 功能组
	 * @param boolean $register
	 * @param string $id
	 */
	public function groupAction($register = true, $id = null, $delete = false) {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$service = $this->get('gost_site_manager.permission_service');
		$sort = array();
		$groups = $service->getFuncGroups();
		$error = null;
		$close_dialog = false;
		$deleteable = false;
		
		if (!$register && $id
				&& ($group = $em->getRepository('GostSiteManagerBundle:MFuncGroup')->find($id))
				&& ($group instanceof MFuncGroup)) {
			$title = '修改功能组';
			$action = $this->generateUrl('gsm_sys_functions_editgroup', array('id'=>$id, 'action'=>'save'));
			$group_form = $this->createForm(new FuncgroupForm(false, count($groups)),
					array('id'=>$group->getId(), 'key'=>$group->getKey(), 'title'=>$group->getTitle(), 'sort'=>$group->getSortNo()));
	
			if (count($group->getFunctions()) == 0) {
				$deleteable = true;
			}
			if ($delete && $deleteable) {
				try {
					$service->deleteFuncGroup($id);
					return $this->jsonRender(array('success'=>true, 'message'=>'功能组已删除'));
				} catch (\Exception $ex) {
					return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
				}
			}
		} else {
			$title = '登记功能组';
			$action = $this->generateUrl('gsm_sys_functions_addgroup', array('action'=>'save'));
			$group_form = $this->createForm(new FuncgroupForm(true, count($groups)));
		}
		
		if ($request->isMethod('POST')
				&& $group_form->bind($request)->isValid()) {
			$data = $group_form->getData();
			try {
				if ($register) {
					$group = $service->createFuncGroup($data['key'], $data['title'], $data['sort']);
				} else {
					$group = $service->updateFuncGroup($data['id'], $data['title'], $data['sort']);
				}
				$close_dialog = true;
			} catch (\Exception $ex) {
				$error = $ex->getMessage();
			}
		}
 
		return $this->smartRender('GostSiteManagerBundle:Function:group.html.twig', $title, array(
				'tab_id' => $this->getCurrentFunc() . '_group',
				'title' => $title,
				'error' => $error,
				'action' => $action,
				'close_dialog' => $close_dialog,
				'deleteable' => $deleteable,
				'group' => isset($group) ? $group : null,
				'group_form' => $group_form->createView()

		));
	}
	
	/**
	 * 登记/修改/删除 功能
	 * @param boolean $register
	 * @param boolean $delete
	 * @param integer $id
	 * @param integer $group
	 */
	public function functionAction($register = true, $delete = false, $id = null, $group = null) {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$service = $this->get('gost_site_manager.permission_service');
		$groups = $service->getFuncGroups();
	
		$sort = array();
		$error = null;
		$close_dialog = false;
		$deleteable = false;
		$title = '登记系统功能';
		$group_functions = $register ? 1 : 0;

		if ($group && ($func_group = $em->getRepository('GostSiteManagerBundle:MFuncGroup')->find($group))
				&& ($func_group instanceof MFuncGroup)) {
			$group_functions += $func_group->getFunctions()->count();
		}
				 
		if (!$register && $id
				&& ($func = $em->getRepository('GostSiteManagerBundle:MFunc')->find($id))
				&& ($func instanceof MFunc)) {
			$deleteable = true;
			if ($delete && $deleteable) {
				try {
					$service->deleteFunction($id);
					return $this->jsonRender(array('success'=>true, 'message'=>'功能已删除'));
				} catch (\Exception $ex) {
					return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
				}
			}
			$action = $this->generateUrl('gsm_sys_functions_editfunc', array('action'=>'save', 'id'=>$id, 'group'=>$group));
		} else {
			$register = true;
			$action = $this->generateUrl('gsm_sys_functions_regfunc', array('action'=>'save', 'group'=>$group));
		}
						 
		if ($request->isMethod('POST') && $request->get('action') == 'save') {
			try {
				$data = $request->request->all();
				$func_actions = array();
				foreach (explode(';', $data['func_actions']) as $func_action) {
					if ($func_action = trim($func_action)) {
						list($code, $title) = explode(':', $func_action);
						$func_actions[intval($code)] = trim($title);
					}
				}
				if ($register) {
					$service->createFunction($data['func_key'], $data['func_title'], $data['func_route'], $data['func_group'],
							$data['sort_no'], isset($data['is_menu']), $func_actions);
				} else {
					$service->updateFunction($id, $data['func_title'], $data['func_route'], $data['func_group'],
							$data['sort_no'], isset($data['is_menu']), $func_actions);
				}
				$close_dialog = true;
			} catch (\Exception $ex) {
				$error = $ex->getMessage();
			}
		}
								 
		return $this->smartRender('GostSiteManagerBundle:Function:function.html.twig', $title, array(
				'tab_id' => $this->getCurrentFunc() . '_function',
				'title' => $title,
				'error' => $error,
				'action' => $action,
				'close_dialog' => $close_dialog,
				'deleteable' => $deleteable,
				'groups' => $groups,
				'group_functions' => $group_functions,
				'current_group' => $group,
				'edit_mode' => !$register,
				'current_func' => isset($func) ? $func : null
		));
	}
	
	/**
	 * 功能权限设置
	 *
	 * @param integer $id
	 */
	public function permissionAction($id) {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$service = $this->get('gost_site_manager.permission_service');
		$error = null;
		$close_dialog = false;
		
		if (($func = $em->getRepository('GostSiteManagerBundle:MFunc')->find($id))
				&& ($func instanceof MFunc)) {
			$title = $func->getTitle() . ' 功能权限设置';
			$roles = $em->getRepository('GostSiteManagerBundle:MRole')->findAll();
			$perms = array();
			foreach ($em->getRepository('GostSiteManagerBundle:MPermission')
					->findBy(array('function'=>$id, 'targetType'=>MPermission::TARGET_TYPE_ROLE)) as $perm) {
				if ($perm instanceof MPermission) {
					$perms[$perm->getTargetId()] = $perm;
				}
			}

			if ($request->isMethod('POST') && ('save' == $request->get('action'))) {
				try {
					$data = $request->request->all();
					foreach ($data['scope'] as $role=>$scope) {
						$permissions = 0;
						if (isset($data['permissions'][$role])) {
							foreach ($data['permissions'][$role] as $action_code) {
								$permissions |= $action_code;
							}
						}
						$service->setFuncPermissions($func, MPermission::TARGET_TYPE_ROLE, $role, $scope, $permissions);
					}
					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}

			return $this->smartRender('GostSiteManagerBundle:Function:permission.html.twig', $title, array(
					'tab_id' => $this->getCurrentFunc() . '_permission',
					'title' => $title,
					'error' => $error,
					'action' => $action = $this->generateUrl('gsm_sys_functions_permission', array('action'=>'save', 'id'=>$id)),
					'close_dialog' => $close_dialog,
					'func' => $func,
					'roles' => $roles,
					'perms' => $perms
			));
		} else {
			return $this->createNotFoundException('功能不存在');
		}
				 
	}
}