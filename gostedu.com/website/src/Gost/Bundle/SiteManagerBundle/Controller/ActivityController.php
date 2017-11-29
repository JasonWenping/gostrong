<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Activity;
use Gost\Bundle\BaseBundle\Form\ActivityType;

/**
 *
 * @author stalker
 *        
 */
class ActivityController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'content_activity';
	}

	/**
	 * 活动列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$nlist = $em->getRepository('GostBaseBundle:Activity')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Content:activitylist.html.twig', '活动列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'activity_list' => $nlist
		));
	}

	/**
	 * 添加活动
	 */
	public function addAction() {

		if ($this->isAllowed('content_activity', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$action = $this->generateUrl('gsm_content_activity_add');
			$form = $this->createForm(new ActivityType());
			$title = '添加活动';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$thumbnail = $form['thumbnail']->getData();
				try {
					if ($thumbnail) {
						$thumbnail_dir = './web/upload/news_thumbnail/';
						$thumbnail_name = time() . '.' . $thumbnail->guessExtension();
						$thumbnail->move($thumbnail_dir, $thumbnail_name);
					}

					$activity_entity = new Activity;
					$time = time();
					$activity_entity->setTitle($data['title'])
						->setThumbnail($thumbnail_dir . $thumbnail_name)
						->setSendtime($time)
						->setContent($data['content'])
						->setChannel(1)
						->setSource($data['source'])
						->setAuthor($data['author'])
						->setAim($data['aim'])
						->setStart_time($data['start_time'])
						->setTemination_time($data['temination_time'])
						->setRule($data['rule'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:activity.html.twig', $title, array(
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
	 * 修改活动
	 */
	public function editAction($id) {
		if ($this->isAllowed('content_activity', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$activity = $em->getRepository('GostBaseBundle:Activity')->find($id);
			$action = $this->generateUrl('gsm_content_activity_edit');
			$form = $this->createForm(new ActivityType());
			$title = '修改活动';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$thumbnail = $form['thumbnail']->getData();
				try {
					if ($thumbnail) {
						$thumbnail_dir = './web/upload/news_thumbnail/';
						$thumbnail_name = time() . '.' . $thumbnail->guessExtension();
						$thumbnail->move($thumbnail_dir, $thumbnail_name);
						unlink($activity->getThumbnail());
						$activity->setThumbnail($thumbnail_dir . $thumbnail_name);
					}

					$time = time();
					$activity->setTitle($data['title'])
						->setSendtime($time)
						->setContent($data['content'])
						->setChannel(1)
						->setSource($data['source'])
						->setAuthor($data['author'])
						->setAim($data['aim'])
						->setStart_time($data['start_time'])
						->setTemination_time($data['temination_time'])
						->setRule($data['rule'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:activity.html.twig', $title, array(
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
	 * 删除活动
	 */
	public function delAction($id) {
		if ($this->isAllowed('content_activity', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($activity = $em->getRepository('GostBaseBundle:Activity')->find($id)) {
					unlink($activity->getThumbnail());
					return $activity->remove($em);
				} else {
					throw new \Exception('该活动不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'活动已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}