<?php 
namespace Chicken\Data;
use Common\Data\DataAccessLayer;
use Common\Data\MySqlParameter;
abstract class CategoryData{

    public static function getCategories(){
        $rtn = null;

        $procedure_name = "usp_categories_s_categories";
        $params = NULL;

        $db = new DataAccessLayer();
        $db->connect();
        $result = $db->ExecuteSelect($procedure_name, $params);
        $db->disconnect();
        $output = 0;
        if (isset($result)) 
        {
			$output = $result;
		}
		$rtn = $output;

		return $rtn;

    }
    
    public static function addCategory($name,$description,$content) {
        $rtn = null;

        $procedureName = "usp_category_i_category"; 
        $params = array(
                new MySqlParameter("pname", $name, 1),
                new MySqlParameter("pdescription", $description, 1),
                new MySqlParameter("pcontent", $content, 1),
                new MySqlParameter("oresult", 0, 2)
           );
        $db = new DataAccessLayer();
        $db->connect();
        $result = $db->ExecuteNonQueryWithOutput($procedureName, $params);
       $db->disconnect();
        if (isset($result)) {
           $rtn = $result["oresult"];
        }

        return $rtn;
    }

    public static function editCategory($categoryid,$name,$description,$content) {
        $rtn = null;

        $procedureName = "usp_category_u_category"; 
        $params = array(
            new MySqlParameter("pcategoryid", $categoryid, 1),
            new MySqlParameter("pname", $name, 1),
            new MySqlParameter("pdescription", $description, 1),
            new MySqlParameter("pcontent", $content, 1),
             new MySqlParameter("oresult", 0, 2)
            );
        $db = new DataAccessLayer();
        $db->connect();
        $result = $db->ExecuteNonQueryWithOutput($procedureName, $params);
        $db->disconnect();
        if (isset($result)) {
            $rtn = $result["oresult"];
        }

        return $rtn;
    }

    public static function deleteCategory($categoryid) {
        $rtn = null;

        $procedureName = "usp_category_d_category"; 
        $params = array(
                new MySqlParameter("pcategory", $categoryid, 1),
                new MySqlParameter("oresult", 0, 2)
            );
        $db = new DataAccessLayer();
        $db->connect();
        $result = $db->ExecuteNonQueryWithOutput($procedureName, $params);
        $db->disconnect();
        if (isset($result)) {
            $rtn = $result["oresult"];
        }

        return $rtn;
   }
}
?>