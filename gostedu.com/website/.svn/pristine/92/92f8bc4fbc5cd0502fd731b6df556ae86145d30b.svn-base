<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\SiteManagerBundle\Entity\MRole;
use Gost\Bundle\SiteManagerBundle\Form\MRoleForm;
use Gost\Bundle\SiteManagerBundle\Entity\MUser;

/**
 * 系统角色管理控制器
 *
 * @author devylee
 *        
 */
class RoleController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'sys_roles';
	}
	
	/**
	 * 系统角色列表
	 */
	public function rolesAction() {
		$roles = $this->getDoctrine()->getEntityManager()
				->getRepository('GostSiteManagerBundle:MRole')
				->findAll();
		
		return $this->smartRender('GostSiteManagerBundle:Role:roles.html.twig', '角色管理', array(
				'tab_id' => $this->getCurrentFunc() . '_roles',
				'roles' => $roles,
		));
	}
	
	public function roleAction($register = true, $id = null, $delete = false) {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$error = null;
		$close_dialog = false;
		$deleteable = false;
		
		if (!$register && $id
				&& ($role = $em->getRepository('GostSiteManagerBundle:MRole')->find($id))
				&& ($role instanceof MRole)) {
			$title = '修改角色定义';
			$action = $this->generateUrl('gsm_sys_roles_edit', array('id'=>$id, 'action'=>'save'));
			$role_form = $this->createForm(new MRoleForm(),
					array('id'=>$role->getId(), 'name'=>$role->getName()));

			if (!$em->getRepository('GostSiteManagerBundle:MUser')
					->findUsersByRole($role->getName())) {
				$deleteable = true;
			}
			if ($delete && $deleteable) {
				try {
					$em->remove($role);
					$em->flush();
					return $this->jsonRender(array('success'=>true, 'message'=>'角色已删除'));
				} catch (\Exception $ex) {
					return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
				}
			}
		} else {
			$title = '登记角色';
			$action = $this->generateUrl('gsm_sys_roles_register', array('action'=>'save'));
			$role_form = $this->createForm(new MRoleForm());
		}
		
		if ($request->isMethod('POST')
				&& $role_form->bind($request)->isValid()) {
			$data = $role_form->getData();
			try {
				if ($register) {
					$role = new MRole();
				}
				$role->setName(strtoupper($data['name']))
						->flush($em);
				$close_dialog = true;
			} catch (\Exception $ex) {
				$error = $ex->getMessage();
			}
		}

		return $this->smartRender('GostSiteManagerBundle:Role:role.html.twig', $title, array(
				'tab_id' => $this->getCurrentFunc() . '_role',
				'title' => $title,
				'error' => $error,
				'action' => $action,
				'close_dialog' => $close_dialog,
				'deleteable' => $deleteable,
				'role' => isset($role) ? $role : null,
				'role_form' => $role_form->createView()

		));
	}
}