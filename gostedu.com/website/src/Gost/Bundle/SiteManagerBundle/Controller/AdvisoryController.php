<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Advisory;
use Gost\Bundle\BaseBundle\Form\AdvisoryType;

/**
 *
 * @author stalker
 *        
 */
class AdvisoryController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'advisory';
	}

	/**
	 * 咨询列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$list = $em->getRepository('GostBaseBundle:Advisory')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Advisory:advisory_list.html.twig', '咨询列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'advisory_list' => $list
		));
	}

	/**
	 * 添加咨询
	 */
	public function addAction() {

		if ($this->isAllowed('advisory', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$action = $this->generateUrl('gsm_advisory_add');
			$form = $this->createForm(new AdvisoryType());
			$title = '添加咨询';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {
					$time = time();
					$advisory_entity = new Advisory;
					$advisory_entity->setName($data['name'])
						->setSchool($data['school'])
						->setMajor($data['major'])
						->setMobile($data['mobile'])
						->setSendtime($time)
						->setAdvisory_time($data['advisory_time'])
						->setRemark($data['remark'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Advisory:advisory_form.html.twig', $title, array(
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
	 * 修改咨询
	 */
	public function editAction($id) {
		if ($this->isAllowed('advisory', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$advisory = $em->getRepository('GostBaseBundle:Advisory')->find($id);
			$action = $this->generateUrl('gsm_advisory_edit');
			$form = $this->createForm(new AdvisoryType());
			$title = '修改咨询';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {
					$time = time();
					$advisory->setName($data['name'])
						->setSchool($data['school'])
						->setMajor($data['major'])
						->setMobile($data['mobile'])
						->setSendtime($time)
						->setAdvisory_time($data['advisory_time'])
						->setRemark($data['remark'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Advisory:advisory_form.html.twig', $title, array(
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
	 * 删除咨询
	 */
	public function delAction($id) {
		if ($this->isAllowed('advisory', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($advisory = $em->getRepository('GostBaseBundle:Advisory')->find($id)) {
					return $advisory->remove($em);
				} else {
					throw new \Exception('该咨询不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'咨询已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}