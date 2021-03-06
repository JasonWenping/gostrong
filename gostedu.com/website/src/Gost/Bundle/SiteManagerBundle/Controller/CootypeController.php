<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Cootype;
use Gost\Bundle\BaseBundle\Form\CootypeType;

/**
 *
 * @author stalker
 *        
 */
class CootypeController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'cootype';
	}

	/**
	 * 合作伙伴类型列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$list = $em->getRepository('GostBaseBundle:Cootype')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Cooperator:cootype_list.html.twig', '合作伙伴类型列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'cootype_list' => $list
		));
	}

	/**
	 * 添加合作伙伴类型
	 */
	public function addAction() {

		if ($this->isAllowed('cootype', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$action = $this->generateUrl('gsm_cootype_add');
			$form = $this->createForm(new CootypeType());
			$title = '添加合作伙伴类型';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {
					$cootype_entity = new Cootype;
					$cootype_entity->setName($data['name'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Cooperator:cootype_form.html.twig', $title, array(
					'tab_id' => $this->getCurrentFunc() . '_add',
					'title' => $title,
					'error' => $error,
					'action' => $action,
					'close_dialog' => $close_dialog,
					'form' => $form->createView()
			));
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行添加。'));
		}
	}

	/**
	 * 修改合作伙伴类型
	 */
	public function editAction($id) {
		if ($this->isAllowed('cootype', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$cootype = $em->getRepository('GostBaseBundle:Cootype')->find($id);
			$action = $this->generateUrl('gsm_cootype_edit');
			$form = $this->createForm(new CootypeType());
			$title = '修改合作伙伴类型';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {
					$cootype->setName($data['name'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Cooperator:cootype_form.html.twig', $title, array(
					'tab_id' => $this->getCurrentFunc() . '_edit',
					'title' => $title,
					'error' => $error,
					'action' => $action,
					'close_dialog' => $close_dialog,
					'form' => $form->createView()
			));
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行修改。'));
		}
	}

	/**
	 * 删除合作伙伴类型
	 */
	public function delAction($id) {
		if ($this->isAllowed('cootype', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($cootype = $em->getRepository('GostBaseBundle:Cootype')->find($id)) {
					return $cootype->remove($em);
				} else {
					throw new \Exception('该合作伙伴类型不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'合作伙伴类型已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}