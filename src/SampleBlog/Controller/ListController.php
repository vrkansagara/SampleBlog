<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 12:55 AM
 */

namespace SampleBlog\Controller;

use SampleBlog\Form\PostForm;
use SampleBlog\Model\Post;
use SampleBlog\Service\PostServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @todo add pagination.
     * @return array|ViewModel
     */
    public function indexAction()
    {

        $perPage = 1;
        // Grab the paginator from the AlbumTable:
        $paginator = $this->postService->findAllPosts(true);

        // Set the current page to what has been passed in query string,
        // or to 1 if none is set, or the page is invalid:

        $page = (int)$this->params()->fromRoute('page', 1);
        $status = (int)$this->params()->fromRoute('status', 1);
//
//        $paginator->setCurrentPageNumber($page);
//
//         Set the number of items per page to 10:
///        $paginator->setItemCountPerPage($perPage);
//
        $setdata = array('status' => $status);
        return new ViewModel(['posts' => $paginator, 'page' => $page, 'setdata' => $setdata]);
    }

    // Add content to this method:
    public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Post();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $post->exchangeArray($form->getData()); // Assign data to object.
                $this->postService->savePost($post);

                // Redirect to list of albums
                return $this->redirect()->toRoute('sampleblog');
            }
        }
        return array('form' => $form);
    }

    // Add content to this method:
    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('sampleblog', array(
                'action' => 'add'
            ));
        }

        // Get the album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $post = $this->postService->findPost($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('sampleblog', array(
                'action' => 'index'
            ));
        }

        $form = new PostForm();
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->postService->savePost($post);

                // Redirect to list of albums
                return $this->redirect()->toRoute('sampleblog');
            } else {
                /**
                 * @todo invalid form show proper notification.
                 */
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    // Add content to the following method:
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('sampleblog');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int)$request->getPost('id');
                $this->postService->deletePost($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('sampleblog');
        }

        return array(
            'id' => $id,
            'post' => $this->postService->findPost($id)
        );
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sl = $this->getServiceLocator();
            $this->albumTable = $sl->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}