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
        //$info     = new SplFileInfo(APP_PATH . 'data');
        // See how use session for home directory and ($_GET['path'] or url rewritting)

        $this->view->setVar('path', '/');
        $path = $this->request->get('path');
        if ($path)
        {
            $this->view->setVar('path', $path);
        }
        $iterator = new FilesystemIterator(APP_PATH . 'data/xavier' . $path);
        //$filter   = new RegexIterator($iterator, '/t.(php|dat)$/');
        /*
        $filelist = array();
        foreach ($iterator as $entry)
        {
            $filelist[] = array(
                'filename' => $entry->getFilename(),
                'realpath' => '/', // See config or DI
                'info' => '',
            );
        }
        $this->view->setVar('filelist', $filelist);
        */
        $this->view->setVar('filelist', $iterator);
    }

    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles())
        {
            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file)
            {
                // Print file details
                echo $file->getName(), " ", $file->getSize(), "\n";
                // Move the file into the application
                $file->moveTo(APP_PATH . 'data/' . $file->getName());
            }
        }
        //$this->view->disable();
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
