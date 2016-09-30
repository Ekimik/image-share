<?php

require '../../../../bootstrap.php';

use \Tester\Assert,
    \Tester\TestCase,
    \App\Model\Adapters\FileSystemUploadAdapter,
    \Nette\Http\FileUpload,
    \Nette\Utils\FileSystem,
    \Nette\Utils\Finder;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class FileSystemUploadAdapterTest extends TestCase {

    protected function setUp() {
        FileSystem::createDir(USER_FILES_DIR);
        FileSystem::createDir(USER_FILES_DIR . '/upload');

        // copy source file
        FileSystem::copy(RESOURCES_DIR . '/testUploadAdapterFile1.txt', USER_FILES_DIR . '/testUploadAdapterFile1.txt', TRUE);
        FileSystem::copy(RESOURCES_DIR . '/testUploadAdapterFile1.txt', USER_FILES_DIR . '/upload/testUploadAdapterFile1.txt', TRUE);
        FileSystem::copy(RESOURCES_DIR . '/testUploadAdapterFile2.txt', USER_FILES_DIR . '/upload/testUploadAdapterFile2.txt', TRUE);
    }

    /**
     * Cleanup after testcase
     */
    protected function tearDown() {
        FileSystem::delete(USER_FILES_DIR);
    }

    /**
     * Addapter assumes files in POST, this sort of smoke test, which check core functionality
     * @covers FileSystemUploadAdapter::upload
     */
    public function testUpload() {
        // check if adapter creates non-existing directory
        $adapter = new FileSystemUploadAdapter();
        $adapter->setAdditionalData(['directory' => 'fooDir']);
        $adapter->setFiles([
            new FileUpload([
                'name' => 'fooFile',
                'type' => 'text/plain',
                'size' => 1,
                'tmp_name' => 'fooTmpFile',
                'error' => UPLOAD_ERR_OK
                    ])
        ]);
        $adapter->upload();
        Assert::true(file_exists(USER_FILES_DIR . '/fooDir'));
        Assert::true(is_dir(USER_FILES_DIR . '/fooDir'));

        // check single file
        $adapter = new FileSystemUploadAdapter();
        $adapter->setFiles([
            new FileUpload([
                'name' => 'testUploadAdapterFile1.txt',
                'type' => 'text/plain',
                'size' => 1024,
                'tmp_name' => USER_FILES_DIR . '/testUploadAdapterFile1.txt',
                'error' => UPLOAD_ERR_OK
                    ])
        ]);

        $adapter->upload();
        Assert::equal(1, Finder::findFiles('*_testUploadAdapterFile1.txt')->from(USER_FILES_DIR)->count());

        // check multiple files
        $adapter = new FileSystemUploadAdapter();
        $adapter->setAdditionalData(['directory' => 'upload']);
        $adapter->setFiles([
            new FileUpload([
                'name' => 'testUploadAdapterFile1.txt',
                'type' => 'text/plain',
                'size' => 1024,
                'tmp_name' => USER_FILES_DIR . '/upload/testUploadAdapterFile1.txt',
                'error' => UPLOAD_ERR_OK
                    ]),
            new FileUpload([
                'name' => 'testUploadAdapterFile2.txt',
                'type' => 'text/plain',
                'size' => 1024,
                'tmp_name' => USER_FILES_DIR . '/upload/testUploadAdapterFile2.txt',
                'error' => UPLOAD_ERR_OK
                    ])
        ]);

        $adapter->upload();
        Assert::equal(1, Finder::findFiles('*_testUploadAdapterFile1.txt')->from(USER_FILES_DIR . '/upload')->count());
        Assert::equal(1, Finder::findFiles('*_testUploadAdapterFile2.txt')->from(USER_FILES_DIR . '/upload')->count());
    }

}

// run test case
$testCase = new FileSystemUploadAdapterTest();
$testCase->run();
