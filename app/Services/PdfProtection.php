<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\Type\PdfDictionary;
use setasign\Fpdi\PdfParser\Type\PdfName;
use setasign\Fpdi\PdfParser\Type\PdfNumber;
use setasign\Fpdi\PdfParser\Type\PdfString;

class PdfProtection extends Fpdi
{
    protected $permissions = [];
    protected $userPassword = '';
    protected $ownerPassword = '';

    public function setProtection(array $permissions, $userPassword = '', $ownerPassword = null)
    {
        $this->permissions = $permissions;
        $this->userPassword = $userPassword;
        $this->ownerPassword = $ownerPassword ?? uniqid();
    }

    protected function _putencryption()
    {
        $this->_newobj();
        $this->_put('<<');
        $this->_put('/Filter /Standard');
        $this->_put('/V 2');
        $this->_put('/R 3');
        $this->_put('/O (' . $this->_escape($this->ownerPassword) . ')');
        $this->_put('/U (' . $this->_escape($this->userPassword) . ')');
        $this->_put('/P ' . $this->_calculatePermissions());
        $this->_put('>>');
        $this->_put('endobj');
    }

    protected function _calculatePermissions()
    {
        $permissions = 0xFFFFFFFC;
        foreach ($this->permissions as $permission) {
            switch ($permission) {
                case 'print':
                    $permissions |= 4;
                    break;
                case 'modify':
                    $permissions |= 8;
                    break;
                case 'copy':
                    $permissions |= 16;
                    break;
                case 'annot-forms':
                    $permissions |= 32;
                    break;
            }
        }
        return -$permissions;
    }
}
