<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Import_View_LC_HC_MVC
{
	public function render()
	{
		$presenter = $this->app->make('/import/presenter');
		$fields = $presenter->fields();
		list( $mandatory_fields, $other_fields ) = $fields;

		$form = $this->app->make('/import/form');
		$helper = $this->app->make('/form/helper');

		$settings = $this->app->make('/app/settings');
		$defaults = array();
		$defaults['core:csv_separator'] = $settings->get('core:csv_separator');

		$inputs_view = $helper->prepare_render( $form->inputs(), $defaults );
		$out_inputs = $helper->render_inputs( $inputs_view );

		$out_buttons = $this->app->make('/html/list-inline')
			->set_gutter(2)
			;

		$out_buttons->add(
			$this->app->make('/html/element')->tag('input')
				->add_attr('type', 'submit')
				->add_attr('title', HCM::__('Upload') )
				->add_attr('value', HCM::__('Upload') )
				->add_attr('class', 'hc-theme-btn-submit')
				->add_attr('class', 'hc-theme-btn-primary')
			);

		$link = $this->app->make('/http/uri')
			->url('/import/upload')
			;
		$out = $helper
			->render( array('action' => $link, 'enctype' => 'multipart/form-data') )
			->add( $out_inputs )
			->add( $out_buttons )
			;

	// help view
		$help_view = $this->app->make('/html/list')
			->set_gutter(1)
			;

		$help_view
			->add(
				$this->app->make('/html/element')->tag('span')
					->add( HCM::__('We can recognize the following columns in your CSV file') )
					->add_attr('class', 'hc-underline')
					->add_attr('class', 'hc-mb2')
					->add_attr('class', 'hc-block')
				)
			;

		foreach( $mandatory_fields as $f ){
			$help_view
				->add(
					$this->app->make('/html/element')->tag('span')
						->add( $f )
						->add_attr('class', 'hc-bold')
					)
				;
		}

		foreach( $other_fields as $f ){
			$help_view
				->add(
					$this->app->make('/html/element')->tag('span')
						->add( $f )
						->add_attr('class', 'hc-italic')
					)
				;
			
		}

		$out = $this->app->make('/html/grid')
			->add( $out, 8 )
			->add( $help_view, 4 )
			;

		return $out;
	}
}