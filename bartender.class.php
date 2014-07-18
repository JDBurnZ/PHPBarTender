<?php

class BarTenderException extends Exception {}

class BarTender {
	private $label;
	private $printer;
	private $label_job_count;
	private $xml;

	/**
	 * @param string $label A full path (including filename,) to a BarTender Label (*.xxx) file.
	 * @param string $printer The name of the printer to which the label will be sent to print.
	 */
	public function __construct($label, $printer) {
		$this->setLabel($label);
		$this->setPrinter($printer);
	}

	/**
	 * @param string $printer The name of the printer to which the label will be sent to print.
	 * @return boolean True on success, Exception thrown on failure
	 * @throws BarTenderException Thrown when $printer is not a string
	 */
	public function setPrinter($printer) {
		if(!is_string($printer)) {
			throw new BarTenderException('Printer passed must be a string, encountered `' . gettype($printer) . '` instead');
		}
		$this->printer = $printer;
		return True;
	}

	/**
	 * @param string $label A full path (including filename,) to a BarTender Label (*.xxx) file.
	 * @return boolean True on success, Exception thrown on failure
	 * @throws BarTenderException Thrown when $label is not a string
	 */
	public function setLabel($label) {
		if(!is_string($label)) {
			throw new BarTenderException('Label passed must be a string, encountered `' . gettype($label) . '` instead');
		}
		$this->label = $label;
		return True;
	}

	/**
	 * @return string The label to be printed
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return string The name of the printer to which the label will be sent to print.
	 */
	public function getPrinter() {
		return $this->printer;
	}

	public function generateToReturn($label_jobs) {
		return $this->_generate($label_jobs);
	}

	public function generateToFile($label_jobs, $filename) {
		$xml = $this->_generate($label_jobs);
		$file_pointer = fopen($filename, 'wb');
		fwrite($file_pointer, $xml);
		fclose($file_pointer);
	}

	private function _generate($label_jobs) {
		$this->label_job_count = 0;
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
		$xml .= '<XMLScript Version="2.0">' . "\r\n";
		foreach($label_jobs as $label_job) {
			$this->label_job_count++;
			$xml .= "\r\n";
			$xml .= $this->_generateEntry($label_job);
		}
		$xml .= '</XMLScript>';
		return $xml;
	}

	private function _generateEntry($label_job) {
		$xml = '';
		$xml .= '	<Command Name="Job' . $this->label_job_count . '">' . "\r\n";
		$xml .= '		<Print>' . "\r\n";
		$xml .= '			<Format>' . $this->label . '</Format>' . "\r\n";
		$xml .= '			<PrintSetup>' . "\r\n";
		$xml .= '				<Printer>' . $this->printer . '</Printer>' . "\r\n";
		$xml .= '			</PrintSetup>' . "\r\n";
		foreach($label_job as $var_name => $var_value) {
			$xml .= '			<NamedSubString Name="' . $var_name . '">' . "\r\n";
			$xml .= '				<Value>' . $var_value . '</Value>' . "\r\n";
			$xml .= '			</NamedSubString>' . "\r\n";
		}
		$xml .= '		</Print>' . "\r\n";
		$xml .= '	</Command>' . "\r\n";
		return $xml;
	}
}
