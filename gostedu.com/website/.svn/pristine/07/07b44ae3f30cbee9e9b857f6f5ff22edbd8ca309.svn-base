<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Channel;
use Gost\Bundle\BaseBundle\Form\ChannelType;

/**
 *
 * @author stalker
 *        
 */
class ChannelController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'content_channel';
	}

	/**
	 * 栏目列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$nlist = $em->getRepository('GostBaseBundle:Channel')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Content:channellist.html.twig', '文章列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'channel_list' => $nlist
		));
	}

	/**
	 * 添加栏目
	 */
	public function addAction() {

		if ($this->isAllowed('content_channel', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$channel_hash = $em->getRepository('GostBaseBundle:Channel')->findAll();
			$action = $this->generateUrl('gsm_content_channel_add');
			$form = $this->createForm(new ChannelType($channel_hash));
			$title = '添加栏目';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$thumbnail = $form['thumbnail']->getData();
				try {
					if ($thumbnail) {
						$thumbnail_dir = './web/upload/channel_thumbnail/';
						$thumbnail_name = time() . '.' . $thumbnail->guessExtension();
						$thumbnail->move($thumbnail_dir, $thumbnail_name);
						$channel->setThumbnail($thumbnail_dir . $thumbnail_name);
					}

					$channel_entity = new Channel;
					$time = time();
					$channel_entity->setName($data['name'])
						->setContent($data['content'])
						->setFid($data['fid'])
						->setIntroduction($data['introduction'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:channel.html.twig', $title, array(
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
	 * 修改栏目
	 */
	public function editAction($id) {
		if ($this->isAllowed('content_channel', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$channel = $em->getRepository('GostBaseBundle:Channel')->find($id);
			$channel_hash = $em->getRepository('GostBaseBundle:Channel')->findAll();
			$action = $this->generateUrl('gsm_content_channel_edit');
			$form = $this->createForm(new ChannelType($channel_hash));
			$title = '修改文章';
			$error = null;
			$close_dialog = false;

			if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
				$data = $form->getData();
				$thumbnail = $form['thumbnail']->getData();
				try {
					if ($thumbnail) {
						$thumbnail_dir = './web/upload/channel_thumbnail/';
						$thumbnail_name = time() . '.' . $thumbnail->guessExtension();
						$thumbnail->move($thumbnail_dir, $thumbnail_name);
						unlink($channel->getThumbnail());
						$channel->setThumbnail($thumbnail_dir . $thumbnail_name);
					}

					$time = time();
					$channel->setName($data['name'])
						->setContent($data['content'])
						->setFid($data['fid'])
						->setIntroduction($data['introduction'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:channel.html.twig', $title, array(
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
	 * 删除栏目
	 */
	public function delAction($id) {
		if ($this->isAllowed('content_channel', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($channel = $em->getRepository('GostBaseBundle:Channel')->find($id)) {
					unlink($channel->getThumbnail());
					return $channel->remove($em);
				} else {
					throw new \Exception('该栏目不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'栏目已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}