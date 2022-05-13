<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Edit_View_LC_HC_MVC
{
	public function render( $model )
	{
		$id = $model['id'];

		$form = $this->app->make('/products/form');
		$helper = $this->app->make('/form/helper');

		$inputs_view = $helper->prepare_render( $form->inputs(), $model );
		$out_inputs = $helper->render_inputs( $inputs_view );

		$out_buttons = $this->app->make('/html/list-inline')
			->set_gutter(2)
			;

		$out_buttons->add(
			$this->app->make('/html/element')->tag('input')
				->add_attr('type', 'submit')
				->add_attr('title', HCM::__('Save') )
				->add_attr('value', HCM::__('Save') )
				->add_attr('class', 'hc-theme-btn-submit')
				->add_attr('class', 'hc-theme-btn-primary')
			);

		$out_buttons->add(
			$this->app->make('/html/ahref')
				->to('/products/' . $model['id'] . '/delete')
				->add_attr('class', 'hcj2-confirm')
				->add( HCM::__('Delete') )
				->add_attr('class', 'hc-right')
				->add_attr('class', 'hc-theme-btn-submit')
				->add_attr('class', 'hc-theme-btn-danger')
			);

		$link = $this->app->make('/http/uri')
			->url('/products/' . $id . '/update')
			;

		$out = $helper
			->render( array('action' => $link) )
			->add(
				$this->app->make('/html/list')
					->set_gutter(2)
					->add( $out_inputs )
					->add( $out_buttons )
				)
			;

		return $out;
	}
}