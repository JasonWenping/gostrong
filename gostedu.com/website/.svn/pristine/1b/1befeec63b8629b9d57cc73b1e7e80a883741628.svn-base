<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Picshow;
use Gost\Bundle\BaseBundle\Form\PicshowType;

/**
 *
 * @author stalker
 *        
 */
class PicshowController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'picshow';
	}

	/**
	 * 幻灯片列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$list = $em->getRepository('GostBaseBundle:Picshow')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Picshow:picshow_list.html.twig', '幻灯片列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'picshow_list' => $list
		));
	}

	/**
	 * 添加幻灯片
	 */
	public function addAction() {

		if ($this->isAllowed('picshow', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$action = $this->generateUrl('gsm_picshow_add');
			$form = $this->createForm(new PicshowType());
			$title = '添加幻灯片';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$image = $form['image']->getData();
				try {
					if ($image) {
						$image_dir = './web/upload/picshow/';
						$image_name = time() . '.' . $image->guessExtension();
						$image->move($image_dir, $image_name);
					}

					$picshow_entity = new Picshow;
					$picshow_entity->setimage($image_dir . $image_name)
						->setUrl($data['url'])
						->setWeight($data['weight'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Picshow:picshow_form.html.twig', $title, array(
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
	 * 修改幻灯片
	 */
	public function editAction($id) {
		if ($this->isAllowed('picshow', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$picshow = $em->getRepository('GostBaseBundle:Picshow')->find($id);
			$action = $this->generateUrl('gsm_picshow_edit');
			$form = $this->createForm(new PicshowType());
			$title = '修改幻灯片';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$image = $form['image']->getData();
				try {
					if ($image) {
						$image_dir = './web/upload/picshow/';
						$image_name = time() . '.' . $image->guessExtension();
						$image->move($image_dir, $image_name);
						unlink($picshow->getThumbnail());
						$picshow->setimage($image_dir . $image_name);
					}
					$picshow->setUrl($data['url'])
						->setWeight($data['weight'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Picshow:picshow_form.html.twig', $title, array(
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
	 * 删除幻灯片
	 */
	public function delAction($id) {
		if ($this->isAllowed('picshow', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($picshow = $em->getRepository('GostBaseBundle:Picshow')->find($id)) {
					unlink($picshow->getThumbnail());
					return $picshow->remove($em);
				} else {
					throw new \Exception('该幻灯片不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'幻灯片已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}