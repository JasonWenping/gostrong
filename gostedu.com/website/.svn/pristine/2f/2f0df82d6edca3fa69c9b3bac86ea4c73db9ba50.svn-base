<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Flink;
use Gost\Bundle\BaseBundle\Form\FlinkType;

/**
 *
 * @author stalker
 *        
 */
class FlinkController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'flink';
	}

	/**
	 * 友情链接列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$nlist = $em->getRepository('GostBaseBundle:Flink')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Flink:flink_list.html.twig', '友情链接列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'flink_list' => $nlist
		));
	}

	/**
	 * 添加友情链接
	 */
	public function addAction() {

		if ($this->isAllowed('flink', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$action = $this->generateUrl('gsm_flink_add');
			$form = $this->createForm(new FlinkType());
			$title = '添加友情链接';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {

					$flink_entity = new Flink;
					$flink_entity->setName($data['name'])
						->setUrl($data['url'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Flink:flink_form.html.twig', $title, array(
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
	 * 修改友情链接
	 */
	public function editAction($id) {
		if ($this->isAllowed('flink', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$flink = $em->getRepository('GostBaseBundle:Flink')->find($id);
			$action = $this->generateUrl('gsm_flink_edit');
			$form = $this->createForm(new FlinkType());
			$title = '修改友情链接';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				try {
					$flink->setName($data['name'])
						->setUrl($data['url'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Flink:flink_form.html.twig', $title, array(
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
	 * 删除友情链接
	 */
	public function delAction($id) {
		if ($this->isAllowed('flink', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($flink = $em->getRepository('GostBaseBundle:Flink')->find($id)) {
					return $flink->remove($em);
				} else {
					throw new \Exception('该友情链接不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'友情链接已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}