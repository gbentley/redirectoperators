<?php

class RedirectOperators
{
    /*!
     Constructor
    */
    function RedirectOperators()
    {
        $this->Operators = array( 'redirectabsolute',
        			  'redirectrelative' );
    }

    /*!
     Returns the operators in this class.
    */
    function &operatorList()
    {
        return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list
    exists per operator type, this is needed for operator classes
    that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     Both operators have one parameter.
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array( 'redirectabsolute' => array( 'to' => array( 'type' => 'string',
                                                                  'required' => true,
                                                                  'default' => '' )),
                      
                      'redirectrelative' => array( 'to' => array( 'type' => 'string',
                                                                  'required' => true,
                                                                  'default' => '' )));
    }

    /*!
     \Executes the needed operator(s).
     \Checks operator names, and calls the appropriate functions.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                     &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'redirectabsolute':
            {
                $operatorValue = $this->redirectAbsolute( $namedParameters['to'] );
            } 
            break;
            
            case 'redirectrelative':
            {
                $operatorValue = $this->redirectRelative( $namedParameters['to'] );
            } 
            break;
    	}
    }

    /*!
     \Redirects to relative URL on the current site
     \The provided relative URL should be of the form /path/to/file.ext
     \Author: http://www.edoceo.com/
     \Tested with PHP versions >= 4.2.0
    */
    function redirectRelative($to)
    {
	$schema = $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
	$host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
	if (headers_sent()) return false;
	else
	{
		//301 - Moved forever. 
    		header("HTTP/1.1 301 Moved Permanently");
    		
		//302 - Use the same method (GET/POST) to request the specified page. 
    		// header("HTTP/1.1 302 Found")
    		
    		//303 - Use GET to request the specified page.
    		// header("HTTP/1.1 303 See Other")
   		   		
    		header("Location: $schema://$host$to");
    		eZExecution::cleanExit();
	}
    }
    
    /*!
     \Redirects to absolute URL
    */
    function redirectAbsolute($to)
    {
	if (headers_sent()) return false;
	else
	{
		//301 - Moved forever. 
    		header("HTTP/1.1 301 Moved Permanently");
    		
		//302 - Use the same method (GET/POST) to request the specified page. 
    		// header("HTTP/1.1 302 Found")
    		
    		//303 - Use GET to request the specified page.
    		// header("HTTP/1.1 303 See Other")

    		header("Location: $to");
    		eZExecution::cleanExit();
	}
    }   

    /// \privatesection
    var $Operators;
}

?>