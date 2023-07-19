<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 08/07/2017
 * Time: 02:32 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
class RecentRegistered  extends Controller
{
    public function index()
    {
        return view('recent');
    }
    public function testPhpgrid()
    {


        $dg = new \phpGrid\C_DataGrid("SELECT c.StoreName ,cs.Price,cs.CustomerSpecial,cs.CostPrice,p.PastelDescription,p.PastelCode,cs.GP,cs.Date,cs.DateTo
 FROM tblcustomerSpecials as cs inner join tblCustomers as c on c.customerId = cs.customerId
inner join viewtblProducts AS P
on p.ProductId = cs.ProductId", "CustomerSpecial", "tblCustomerSpecials");
        //$dg ->set_dimension(1800, 1300);
        $dg -> set_col_hidden('CustomerSpecial', false);
        $dg -> set_col_readonly("CustomerSpecial,StoreName,PastelDescription,PastelCode,CostPrice,ProductId");
        $dg->enable_autowidth(true)->enable_autoheight(true);
        $onGridLoadComplete = <<<ONGRIDLOADCOMPLETE
function(status, rowid)
{
alert("control"+rowid);
    var ids = jQuery("#tblCustomerSpecials").jqGrid('getDataIDs');
    for (var i = 0; i < ids.length; i++)
    {
        var rowId = ids[i];
        var rowData = jQuery('#tblCustomerSpecials').jqGrid ('getRowData', rowId);

alert($("#tblCustomerSpecials").jqGrid("getCell", rowId, "status"));
        if($("#tblCustomerSpecials").jqGrid("getCell", rowId, "status") == "Shipped"){
            $("#tblCustomerSpecials").jqGrid("setCell", rowId, "actions", " zzz ", {"display":"none"}); // not possible to set value for virtual column
        }
    }
}
ONGRIDLOADCOMPLETE;
        $dg->add_event("jqGridInlineSuccessSaveRow", $onGridLoadComplete);
       // $dg -> set_pagesize(10000);
        $dg->set_scroll(true);
        $dg->enable_kb_nav(true);
        $dg->enable_edit('CELL');
        $dg->enable_export('PDF');
        $dg -> enable_columnchooser(true);
        $dg -> set_sortablerow(true);
        $dg->add_column("actions",
            array('name'=>'actions',
            'index'=>'actions',
            'width'=>'70',
            'formatter'=>'actions',
            'formatoptions'=>array('keys'=>true, 'delbutton'=>true)),'Actions');
        $dg->enable_pagecount(false);

        $dg->enable_edit("INLINE");

        $dg->set_theme('cobalt');
        //$dg->set_theme('cobalt-flat');
        $dg ->enable_search(true);
        //  $dg->set_grid_property(array('cmTemplate'=>array('title'=>false)));
        $dg->display(false);


        $dg -> set_col_property("DateTo",
            array("formatter"=>"date",
                "sorttype"=>"date",
                "searchoptions"=>
                    array("dataInit"=>"###datePick###")));
        $dg->enable_advanced_search(true);

        $grid = $dg -> get_display(true);

        //dd($grid);


        return view('mass_specials', ['grid' => $grid]);
    }
    //
    public function instocksheet()
    {
        $dg = new \phpGrid\C_DataGrid("select * from vwInStockQty ", "ProductId", "vwInStockQty");
        $dg->enable_edit("FORM", "CRUD");
        $dg->enable_autowidth(true)->enable_autoheight(true);

        $dg->set_theme('cobalt-flat');
        $dg -> set_col_edittype("Binnumber", "select", "select Binnumber from vwInStockQty",false);
       // $dg->set_group_properties('Binnumber');
        $dg->set_grid_property(array('cmTemplate'=>array('title'=>false)));
        $dg->display(false);

        $grid = $dg -> get_display(true);

        //dd($grid);


        return view('dims/stock_report', ['grid' => $grid]);
    }


}