<?php

class ListController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('List all files and directories');
        parent::initialize();
    }

    /**
     * @todo : need control on '/../../../../../../../'
     */
    public function indexAction()
    {
        $this->view->setVar('path', '/');
        $path = '/' . trim($this->request->get('f'), '/');
        if ($path)
        {
            $this->view->setVar('path', $path);
        }

        try
        {
            $iterator = new FilesystemIterator(APP_PATH . 'data/xavier' . $path);
        }
        catch (UnexpectedValueException $e)
        {
            $iterator = null;
            $this->flash->error("Directory not exist !");
        }
        catch (Exception $e)
        {
            $iterator = null;
            $this->flash->error("You don't have permission to access this area");
        }
        $this->view->setVar('filelist', $iterator);
    }

    public function uploadAction()
    {
        $ret = array();
        // Check if the user has uploaded files
        if ($this->request->hasFiles())
        {
            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file)
            {
                // TODO: Here add filter extension, control, spyware, virus, etc...
                $ret = array(
                    'filename' => $file->getName(),
                    'filesize' => $file->getSize()
                );
                // Move the file into the application
                $file->moveTo(APP_PATH . 'data/xavier/' . $file->getName());
            }
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($ret);
        return $this->response;
    }

    public function createAction()
    {
        $ret = array('status' => false, 'msg' => 'error-need-filename');
        if ($this->request->isPost() == true && $this->request->isAjax() == true)
        {
            $action = $this->request->getPost("action", array("string", "trim", "lower"));
            $dir_path = $this->request->getPost("path");
            $dir_name = $this->request->getPost("name");
            if ($action === 'dir-create' && $dir_path !== '' && $dir_name !== '')
            {
                if (is_dir(APP_PATH . 'data/xavier/' . $dir_path . '/' . $dir_name))
                {
                    $ret = array('status' => false, 'msg' => 'error-dir-exist');
                }
                elseif (!mkdir(APP_PATH . 'data/xavier/' . $dir_path . '/' . $dir_name))
                {
                    $ret = array('status' => false, 'msg' => 'error-dir-not-create');
                }
                else
                {
                    $ret = array('status' => true, 'msg' => 'ok');
                }
            }
        }
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($ret);
        $this->view->disable();
        return $this->response;
         // JSON identified ???
        //if ($this->request->getBestAccept() == 'application/json')
        //{
        //}
    }

    public function createMongoAction()
    {
        $file       = new Files();
        $file->type = "video";
        $file->name = "Astro Boy";
        $file->year = 1952;
        if ($file->save() == false)
        {
            echo "Umh, We can't store files right now: \n";
            foreach ($file->getMessages() as $message)
            {
                echo $message, "\n";
            }
        }
        else
        {
            echo "Great, a new file was saved successfully !";
        }
    }
}
