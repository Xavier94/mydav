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
        $iterator = new FilesystemIterator(APP_PATH . 'data/xavier');
        //$filter   = new RegexIterator($iterator, '/t.(php|dat)$/');
        $filelist = array();
        foreach ($iterator as $entry)
        {
            $filelist[] = $entry->getFilename();
        }
        $this->view->setVar('filelist', $filelist);
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
}
