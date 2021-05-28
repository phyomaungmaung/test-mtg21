<?php

namespace App\Exports;

use App\Entities\Category;
use App\Entities\Result;
use Illuminate\Support\Collection;
use Iterator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromIterator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SemiResultDetailByCategoryExport implements FromCollection , WithDrawings,
    WithTitle, WithHeadings, ShouldAutoSize, WithEvents, WithHeadingRow, WithMapping
{

    private $category,$datas,$attibutes,$full_attributes;

    public function __construct(Category $category,Collection $datas,array $attibutes=[])
    {
        $this->category = $category;
        $this->attibutes= $attibutes;
        $this->datas= $datas;
        $fname = config('full_name');
        $this->full_attributes=[];
        foreach ($attibutes as $k=>$v){
            $this->full_attributes[]=$fname[$v];
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->datas;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->category->name;
    }

    /**
     * @return BaseDrawing|BaseDrawing[]
     */
    public function drawings()
    {

        $tmp = new Drawing();
        $tmp->setPath(public_path('images/img/aictalogo.png')); //your image path
        $tmp->setCoordinates('A1');
        $tmp->setName('Logo');
        $tmp->setDescription('Logo');
        $tmp->setHeight(90);
        return $tmp;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return array_merge(['Judge name','Judge Country','Score'],$this->full_attributes );
    }




    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class=>function(BeforeSheet $even) {
                $sheet = $even->getSheet();
                $sheet->appendRows([ [' '],[' '],[' '],[' '],[' '],[" "]],$sheet);
                $sheet->getDelegate()->setCellValue('B2', 'Score Detail for category  '.$this->category->name);
                $sheet->getDelegate()->mergeCells('B2:M4');
                $style = array(
                    'alignment' => array(
                        'horizontal' =>  Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER

                    ),
                    'font' => array(
                        'bold' => true,
                        //                        'color' => array('rgb' => 'FF0000'),
                        'size' => 15,
                        'name' => 'Verdana'
                    )
                );
                $sheet->getDelegate()->getStyle('B2:M4')->applyFromArray($style);

            },
            AfterSheet::class => function(AfterSheet $event){
                $sheet = $event->getSheet();
                $cell = "A5:P60";
                $style = array(
                    'alignment' => array(
                        'wrapText'=>true,
                        'horizontal' =>  Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER

                    ),
                    'font' => array(
//                        'bold' => true,
                        //                        'color' => array('rgb' => 'FF0000'),
                        'size' => 10,
                        'name' => 'Verdana'
                    )
                );
                $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($style);

                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getDelegate()->getStyle("A7:O7")->getFont()->setBold(true);


            }
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        $r=$row;
        if( isset($row['en'])){
            $r=[];
            $r = [
                $row["username"],$row['country'],$row["score"]
            ];
            foreach ($this->attibutes as $att) {
                $r[]=$row[$att];
            }
        }

        return $r;
    }
}
