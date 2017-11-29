<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\News;
use Gost\Bundle\BaseBundle\Form\NewsType;

/**
 *
 * @author stalker
 *        
 */
class NewsController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'content_news';
	}

	/**
	 * 新闻列表
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction() {
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$nlist = $em->getRepository('GostBaseBundle:News')->findAll();
		return $this->smartRender('GostSiteManagerBundle:Content:newslist.html.twig', '文章列表', array(
				'tab_id' => $this->getCurrentFunc(),
				'news_list' => $nlist
		));
	}

	/**
	 * 添加新闻
	 */
	public function addAction() {

		if ($this->isAllowed('content_news', 2)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$channel_hash = $em->getRepository('GostBaseBundle:Channel')->findAll();
			$action = $this->generateUrl('gsm_content_news_add');
			$form = $this->createForm(new NewsType($channel_hash));
			$title = '添加新闻';
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

					$news_entity = new News;
					$time = time();
					$news_entity->setTitle($data['title'])
						->setThumbnail($thumbnail_dir . $thumbnail_name)
						->setSendtime($time)
						->setContent($data['content'])
						->setChannel($data['channel'])
						->setSource($data['source'])
						->setAuthor($data['author'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:news.html.twig', $title, array(
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
	 * 修改新闻
	 */
	public function editAction($id) {
		if ($this->isAllowed('content_news', 4)) {
			$request = $this->getRequest();
			$em = $this->getDoctrine()->getManager();
			$news = $em->getRepository('GostBaseBundle:News')->find($id);
			$channel_hash = $em->getRepository('GostBaseBundle:Channel')->findAll();
			$action = $this->generateUrl('gsm_content_news_edit');
			$form = $this->createForm(new NewsType($channel_hash));
			$title = '修改文章';
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
						unlink($news->getThumbnail());
						$news->setThumbnail($thumbnail_dir . $thumbnail_name);
					}

					$time = time();
					$news->setTitle($data['title'])
						->setSendtime($time)
						->setContent($data['content'])
						->setChannel($data['channel'])
						->setSource($data['source'])
						->setAuthor($data['author'])
						->flush($em);

					$close_dialog = true;
				} catch (\Exception $ex) {
					$error = $ex->getMessage();
				}
			}
			return $this->smartRender('GostSiteManagerBundle:Content:news.html.twig', $title, array(
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
	 * 删除新闻
	 */
	public function delAction($id) {
		if ($this->isAllowed('content_news', 8)) {
			try {
				$em = $this->getDoctrine()->getManager();
				if ($news = $em->getRepository('GostBaseBundle:News')->find($id)) {
					unlink($news->getThumbnail());
					return $news->remove($em);
				} else {
					throw new \Exception('该新闻不存在。');
				}
				return $this->jsonRender(array('success'=>true, 'message'=>'新闻已删除'));
			} catch (\Exception $ex) {
				return $this->jsonRender(array('error'=>true, 'message'=>$ex->getMessage()));
			}
		} else {
			return $this->jsonRender(array('error'=>true, 'message'=>'无权进行删除'));
		}
	}
}