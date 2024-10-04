<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Contract; 
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\Settings;

class ContractController extends Controller
{
    public function showCreateContractView()
    {
        // $contracts =  $this->getAllColumnsOfTable('contracts');
        // return view('create-contract', compact('contracts'));
        return view('create-contract', compact('contracts'));
    }
    

    public function createAndSaveContract(Request $request)
    {
        //return $this->getAllColumnsOfTable('contracts');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $templatePath = storage_path('app/public/contract_template.docx');
        $template = IOFactory::load($templatePath);

        $data = $request->all();
        $sections = $template->getSections();

        foreach ($sections as $section) {
            $elements = $section->getElements();

            foreach ($elements as $element) {
            
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $text) {
                        $text->setText(str_replace(['{name}', '{age}'], [$data['name'], $data['age']], $text->getText()));
                    }
                }
            }
        }

        $contract = new Contract();
        $contract->name = $data['name'];
        $contract->age = $data['age'];
        $contract->save();

        $outputPath = storage_path('app/public/'.$contract->id.'_contract.docx');
        $template->save($outputPath);

        return response()->json(['message' => 'Contract created and saved successfully.']);
    }

    private function getAllColumnsOfTable($tableName)
    {
        if (Schema::hasTable($tableName)) {
            $columns = Schema::getColumnListing($tableName);
            return $columns;
        }

        return [];
    }

    public function wordView()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Hello, this is a sample Word document!');

        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $phpWord->save($tempFile, 'Word2007');

        return view('word_viewer', ['tempFile' => $tempFile]);
    }

    // public function wordShow()
    // {
    //     $filename = 'contract_template.docx';
    //     $filePath = storage_path('app/public/' . $filename);
        

    //     // Kiểm tra xem tệp có tồn tại không
    //     if (!file_exists($filePath)) {
    //         abort(404);
    //     }
        
    //     // Đọc nội dung từ tệp Word
    //     $phpWord = IOFactory::load($filePath);
    //     $sections = $phpWord->getSections();

    //     // Chuyển đổi nội dung thành văn bản
    //     $text = '';
    //     foreach ($sections as $section) {
    //         $elements = $section->getElements();

    //         foreach ($elements as $element) {
    //             if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
    //                 foreach ($element->getElements() as $textElement) {
    //                     $text .= $textElement->getText();
    //                 }
    //             }
    //         }
    //     }

    //     return view('word_viewer', ['text' => $text]);
    // }

    public function wordShow()
    {
        $filename = 'contract_template.docx';
        $filePath = storage_path('app/public/' . $filename);

        // Kiểm tra xem tệp có tồn tại không
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Đọc nội dung từ tệp Word
        $phpWord = IOFactory::load($filePath);
        $htmlContent = $this->convertToHtml($phpWord);

        return view('word_viewer', ['htmlContent' => $htmlContent]);
    }

    private function convertToHtml($phpWord)
    {
        // Đặt cấu hình để sử dụng môi trường HTML
        Settings::setOutputEscapingEnabled(true);

        // Sử dụng WriterFactory để tạo đối tượng HTMLWriter
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        // Sử dụng stream_get_contents để lấy nội dung HTML
        ob_start();
        $htmlWriter->save("php://output");
        $htmlContent = ob_get_clean();

        return $htmlContent;
    }

    public function wordSave(Request $request)
    {
        $content = $request->input('content');
        $filename = 'edited_contract.docx';
        $filePath = storage_path('app/public/' . $filename);

        // Thực hiện các bước cần thiết để lưu nội dung vào tệp Word
        $this->saveWordFile($filePath, $content);

        return response()->json(['message' => 'Word file saved successfully.']);
    }

    private function saveWordFile($filePath, $content)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();
        $section->addText($content);
    
        // Lưu tệp Word
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $objWriter->save($filePath);
    }

}
