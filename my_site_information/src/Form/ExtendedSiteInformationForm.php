<?php

namespace Drupal\my_site_information\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
        '#type' => 'textfield',
        '#title' => t('Site API Key'),
        '#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
        '#description' => t("Custom field to set the API Key"),
    ];

    $form['actions']['submit']['#value'] = $this->t('Update configuration');
    
    return $form;
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $api_value = $form_state->getValue('siteapikey');  
    $this->config('system.site')
      ->set('siteapikey', $api_value)
      ->save();
    drupal_set_message('The Site API Key has been saved with value ' . $api_value);  
    parent::submitForm($form, $form_state);
  }
	  
}
