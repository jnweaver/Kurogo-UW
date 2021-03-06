<?php


class WSDLParser extends XMLDataParser
{
    protected $wsdl;

    protected static $startElements=array(
    
    );
    
    protected static $endElements=array(
        'XS:IMPORT'
    );
    
    protected function shouldStripTags($element) {
        return false;
    }

    protected function shouldHandleStartElement($name) {
        return in_array($name, self::$startElements);
    }
        
    protected function handleStartElement($name, $attribs) {
    }    

    protected function shouldHandleEndElement($name) {
        return in_array($name, self::$endElements);
    }
    
    protected function handleEndElement($name, $element, $parent) {
        switch ($name) {
            case 'XS:IMPORT':
                /* add the locations to the object if they are defined */
                if ($location = $element->getAttrib('SCHEMALOCATION')) {
                    $this->wsdl->addImport($location);
                }
                break;
        }
    }
    
    public function clearInternalCache() {
        parent::clearInternalCache();
        $this->wsdl = new WSDLData();
    }
    
    public function parseData($xml) {
        $this->clearInternalCache();
        $this->parseXML($xml);
        return $this->wsdl;
    }
}

class WSDLData
{
    protected $imports = array();
    
    public function addImport($import) {
        $this->imports[] = $import;
    }
    
    public function getImports() {
        return $this->imports;
    }
}
