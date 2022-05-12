<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Index_View_LC_HC_MVC
{
	public function render( $entries )
	{
		$header = $this->header();

		$rows = array();
		foreach( $entries as $e ){
			$rows[$e['id']] = $this->row($e);
		}

		if( ! $rows ){
			return;
		}

		$out = $this->app->make('/html/table-responsive')
			->set_no_footer(FALSE)
			->set_header($header)
			->set_rows($rows)
			;

		$out = $this->app->make('/html/element')->tag('div')
			->add( $out )
			->add_attr('class', 'hc-border')
			;

	// add bulk form
		$helper = $this->app->make('/form/helper');

		$bulk_form = $this->bulk_form();

		$out = $this->app->make('/html/list')
			->set_gutter(1)
			->add( $bulk_form )
			->add( $out )
			;

		$link = $this->app->make('/http/uri')
			->url('/products/bulk')
			;
		$out = $helper
			->render( array('action' => $link) )
			->add( $out )
			;

		return $out;
	}

	public function bulk_form()
	{
		$form = $this->app->make('/products/bulk/form');

		$helper = $this->app->make('/form/helper');
		$inputs_view = $helper->prepare_render( $form->inputs() );

		$btn = $this->app->make('/html/element')->tag('input')
			->add_attr('type', 'submit')
			->add_attr('title', HCM::__('Apply') )
			->add_attr('value', HCM::__('Apply') )
			->add_attr('class', 'hc-theme-btn-submit')
			;

		$out = $this->app->make('/html/list-inline')
			->set_gutter(1)
			->add( $inputs_view['action'] )
			->add( $btn )
			;

		return $out;
	}

	public function header()
	{
		$return = array();

		$title_view = HCM::__('Title');

	// add checkbox
		$checkbox = $this->app->make('/form/checkbox')
			->render('')
			->add_attr('class', 'hcj2-all-checker')
			->add_attr('data-collect', 'hc-id[]')
			;

		$title_view = $this->app->make('/html/list-inline')
			->set_gutter(1)
			->add( $checkbox )
			->add( $title_view )
			;

		$return['title'] = $title_view;
		$return['order'] = HCM::__('Show Order');
		$return['id'] = 'ID';
		return $return;
	}

	public function row( $e )
	{
		$return = array();
		if( ! $e ){
			return $return;
		}

		$row = array();

		$title_view = $e['title'];
		$title_view = $this->app->make('/html/ahref')
			->to('/products/' . $e['id'] . '/edit')
			->add( $title_view )
			;

	// add checkbox
		$checkbox = $this->app->make('/form/checkbox')
			->set_value( $e['id'] )
			->render( 'id[]' )
			;

		$title_view = $this->app->make('/html/list-inline')
			->set_gutter(1)
			->add( $checkbox )
			->add( $title_view )
			;

		$order_view = $this->app->make('/form/text')
			->set_size( 3 )
			->render( 'show_order_' . $e['id'], $e['show_order'] )
			;

		$row['title'] 	= $title_view;
		$row['order'] 	= $order_view;
		$row['id']		= $e['id'];

		return $row;
	}
}