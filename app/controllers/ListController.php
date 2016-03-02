<?php

class ListController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('List all files and directories');
        parent::initialize();
    }

    public function indexAction()
    {
        //$info     = new SplFileInfo(APP_PATH . 'data');

        // See how use session for home directory and ($_GET['path'] or url rewritting)

        $iterator = new FilesystemIterator(APP_PATH . 'data/xavier');
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

    public function createDirAction()
    {
        $this->view->disable();
        if ($this->request->isPost() == true && $this->request->isAjax() == true)
        {
            echo json_encode(array('s' => true));
            return;
        }
        echo json_encode(array('s' => false));
    }

    public function createAction()
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
