<?php

namespace qtism\data\rules;

use qtism\data\QtiComponentCollection;

use qtism\data\QtiComponent;

/**
 * From IMS QTI:
 * 
 * If the expression given in a responseIf or responseElseIf evaluates to true 
 * then the sub-rules contained within it are followed and any following 
 * responseElseIf or responseElse parts are ignored for this response condition.
 * 
 * If the expression given in a responseIf or responseElseIf does not evaluate 
 * to true then consideration passes to the next responseElseIf or, if there are 
 * no more responseElseIf parts then the sub-rules of the responseElse are 
 * followed (if specified).
 * 
 * @author Jérôme Bogaerts <jerome@taotesting.com>
 *
 */
class ResponseCondition extends QtiComponent implements ResponseRule {
	
	/**
	 * A ResponseIf object.
	 * 
	 * @var ResponseIf
	 */
	private $responseIf;
	
	/**
	 * A collection of ResponseElseIf objects.
	 * 
	 * @var ResponseElseIfCollection
	 */
	private $responseElseIfs;
	
	/**
	 * An optional ResponseElse object.
	 * 
	 * @var ResponseElse
	 */
	private $responseElse = null;
	
	/**
	 * Create a new instance of ResponseCondition.
	 * 
	 * @param ResponseIf $responseIf An ResponseIf object.
	 * @param ResponseElseIfCollection $responseElseIfs A collection of ResponseElseIf objects.
	 * @param ResponseElse $responseElse An ResponseElse object.
	 */
	public function __construct(ResponseIf $responseIf, ResponseElseIfCollection $responseElseIfs = null, ResponseElse $responseElse = null) {
		$this->setResponseIf($responseIf);
		$this->setResponseElse($responseElse);
		$this->setResponseElseIfs((is_null($responseElseIfs)) ? new ResponseElseIfCollection() : $responseElseIfs);
	}
	
	/**
	 * Get the ResponseIf object.
	 * 
	 * @return ResponseIf A ResponseIf object.
	 */
	public function getResponseIf() {
		return $this->responseIf;
	}
	
	/**
	 * Set the ResponseIf object.
	 * 
	 * @param ResponseIf $responseIf A ResponseIf object.
	 */
	public function setResponseIf(ResponseIf $responseIf) {
		$this->responseIf = $responseIf;
	}
	
	/**
	 * Get the collection of ResponseElseIf objects.
	 * 
	 * @return ResponseElseIfCollection A ResponseElseIfCollection object.
	 */
	public function getResponseElseIfs() {
		return $this->responseElseIfs;
	}
	
	/**
	 * Set the collection of ResponseElseIf objects.
	 * 
	 * @param ResponseElseIfCollection $responseElseIfs A ResponseElseIfCollection object.
	 */
	public function setResponseElseIfs(ResponseElseIfCollection $responseElseIfs) {
		$this->responseElseIfs = $responseElseIfs;
	}
	
	/**
	 * Get the optional ResponseElse object. Returns null if not specified.
	 * 
	 * @return ResponseElse A ResponseElse object.
	 */
	public function getResponseElse() {
		return $this->responseElse;
	}
	
	/**
	 * Set the optional ResponseElse object. A null value means there is no else.
	 * 
	 * @param ResponseElse $responseElse A ResponseElse object.
	 */
	public function setResponseElse(ResponseElse $responseElse = null) {
		$this->responseElse = $responseElse;
	}
	
	public function getQtiClassName() {
		return 'responseCondition';
	}
	
	public function getComponents() {
		$comp = array_merge(array($this->getResponseIf()),
							$this->getResponseElseIfs()->getArrayCopy());
		
		if (!is_null($this->getResponseElse())) {
			$comp[] = $this->getResponseElse();
		}
		
		return new QtiComponentCollection($comp);
	}
}