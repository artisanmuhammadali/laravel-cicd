<?php

namespace App\Services\User;

use App\Models\UserKyc;
use App\Models\UserWallet;
use App\Traits\EscrowTransfer;
use Exception;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MangoPayService {
 
    use EscrowTransfer;
    private $mangoPayApi;

    public function __construct()
    {   
        $data = Config::get('helpers.mango_pay');
        $this->mangoPayApi = new MangoPay();
        $this->mangoPayApi->Config->ClientId = $data['client_id'];
        $this->mangoPayApi->Config->ClientPassword = $data['client_password'];
        $this->mangoPayApi->Config->TemporaryFolder = '../../';
        $this->mangoPayApi->Config->BaseUrl = $data['base_url'];
        // $this->mangoPayApi->Config->BasGBPl = 'https://api.sandbox.mangopay.com';
    }
    public function createMangoPayUser($user , $role , $request)
    {
        if ($role == "business"){
            return $this->createLegalUser($user , $request);
        }
        else{
            return $this->createNaturalUser($user);
        }
    }
    public function createNaturalUser($user)
    {
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        try {
            $mangoUser = new \MangoPay\UserNatural();
            $mangoUser->Email = $user->email;
            $mangoUser->FirstName = $user->first_name;
            $mangoUser->LastName = $user->last_name;
            $mangoUser->UserCategory = "OWNER";
            $mangoUser->Nationality = "GB";
            $mangoUser->Birthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975);
            $mangoUser->CountryOfResidence = "GB";
            $mangoUser->TermsAndConditionsAccepted = true;
            $mangoUser= $this->mangoPayApi->Users->Create($mangoUser);

            // $this->createKyc($mangoUser , $user->store->photo_id_scan , 'IDENTITY_PROOF');

            $mangoUser = (object)$mangoUser;
            return $mangoUser->Id;
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
    public function updateNaturalUser($request)
    {
        $user = auth()->user();
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        try {
            $mangoUser = $this->mangoPayApi->Users->Get($user->store->mango_id);
            $mangoUser->Email = $user->email;
            $mangoUser->FirstName = $user->first_name;
            $mangoUser->LastName = $user->last_name;
            $mangoUser->UserCategory = "OWNER";
            $mangoUser->Nationality = $request->nationality;
            $mangoUser->Birthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975);
            $mangoUser->CountryOfResidence = "GB";
            $mangoUser->TermsAndConditionsAccepted = true;
            $mangoUser= $this->mangoPayApi->Users->Update($mangoUser);

            $mangoUser = (object)$mangoUser;
            return $mangoUser->Id;
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
    public function createLegalUser($user , $request)
    {
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        try {
            $mangoUser = new \MangoPay\UserLegal();
            $mangoUser->Name = $user->full_name;
            $mangoUser->Email = $user->email;
            $mangoUser->LegalPersonType = "BUSINESS";
            $mangoUser->KYCLevel = "LIGHT";

            $address = new \MangoPay\Address();
            $address->AddressLine1 = $user->seller_address->street_number;
            $address->City = $user->seller_address->city;
            $address->Country = "GB";
            $address->PostalCode = $user->seller_address->postal_code;
            $address->Region = $user->seller_address->city;
            
            $mangoUser->HeadquartersAddress = $address;
            $mangoUser->LegalRepresentativeAddress = $address;
            $mangoUser->LegalRepresentativeFirstName = $user->first_name;
            $mangoUser->LegalRepresentativeLastName = $user->last_name;
            $mangoUser->LegalRepresentativeEmail = $user->email;
            $mangoUser->LegalRepresentativeBirthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975);
            $mangoUser->LegalRepresentativeNationality = $request->nationality;
            $mangoUser->LegalRepresentativeCountryOfResidence = "GB";
            $mangoUser->CompanyNumber = $user->store->company_no;
            $mangoUser->Tag = 'Created using Mangopay PHP SDK';
            $mangoUser->TermsAndConditionsAccepted = true;
            $mangoUser->UserCategory = 'Owner';

            $mangoUser = $this->mangoPayApi->Users->Create($mangoUser);
            $this->createUBO($mangoUser->Id , $request); 
            $mangoUser = (object)$mangoUser;
            return $mangoUser->Id;
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
    public function updateLegalUser($user , $request)
    {
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        try {
            $mangoUser = $this->mangoPayApi->Users->Get($user->store->mango_id);
            $mangoUser->Name = $user->full_name;
            $mangoUser->Email = $user->email;
            $mangoUser->LegalPersonType = "BUSINESS";

            $mangoUser->LegalRepresentativeNationality = $request->nationality;
            $mangoUser->UserCategory = 'Owner';

            $mangoUser = $this->mangoPayApi->Users->Update($mangoUser);
            $this->createUBO($user->store->mango_id , $request); 
            $mangoUser = (object)$mangoUser;
            return $mangoUser->Id;
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
    public function createKyc($mangoUser , $file , $type)
    {
        // dd($file);
        set_time_limit(0);

        $UserId = $mangoUser;
        $KycDocument = new \MangoPay\KycDocument();
        $KycDocument->Tag = "custom meta";
        $KycDocument->Type = $type;
        $Document = $this->mangoPayApi->Users->CreateKycDocument($UserId, $KycDocument);
        
        $KYCDocumentId = $Document->Id;
        $KycPage = new \MangoPay\KycPage();
        $KycPage->File = $file;
        $this->mangoPayApi->Users->CreateKycPageFromFile($UserId, $KYCDocumentId, $KycPage->File);

        $KycDocument = new \MangoPay\KycDocument();
        $KycDocument->Id = $Document->Id;
        $KycDocument->Status = \MangoPay\KycDocumentStatus::ValidationAsked;
        $SubmitDoc = $this->mangoPayApi->Users->UpdateKycDocument($UserId ,$KycDocument);
        return $SubmitDoc;   
    }
    public function tranferWalletAmount($old_wallet , $new_wallet)
    {
        try {
            $old_wallet_id = $old_wallet->wallet_id ?? null;
            $old_user_id = $old_wallet->user_mangopay_id ?? $old_wallet->mangopay_id;
            $old_user_id = $old_user_id == 0 ? $old_wallet->mangopay_id : $old_user_id;

            $new_wallet_id = $new_wallet->wallet_id ?? null;
            $new_user_id = $new_wallet->user_mangopay_id ?? $new_wallet->mangopay_id;
            $new_user_id = $new_user_id == 0 ? $new_wallet->mangopay_id : $new_user_id;
            $wallet = $this->mangoPayApi->Wallets->Get($old_wallet_id);
            $oldWalletAmount = $wallet->Balance->Amount;
            $credit_user = [
                'id'=>$new_user_id,
                'wallet_id'=>$new_wallet_id,
            ];
            $debit_user = [
                'id'=>$old_user_id,
                'wallet_id'=>$old_wallet_id,
            ];
            if($oldWalletAmount != 0)
            {
                $this->transferOldAmountTONewWallet($credit_user , $debit_user , $oldWalletAmount , 'Old User to new user transfer');
            }
            return true;
        } catch (\Throwable $th) {
        }
    }
    public function createWallet($id , $user_id)
    {
        try {
            UserWallet::where('user_id',$user_id)->update(['active'=>0]);
            $wallet = new \MangoPay\Wallet();

            $wallet->Owners = [$id];
            $wallet->Currency = 'GBP';
            $wallet->Description = 'GBP General Wallet';
            $wallet->Tag = 'General Wallet For Managing Users e-money';

            $response = $this->mangoPayApi->Wallets->Create($wallet);
            UserWallet::create([
                'wallet_id'=>$response->Id,
                'user_id'=>$user_id,
                'type'=>'normal',
                'user_mangopay_id'=>$id,
                'mangopay_id'=>$id
            ]);
            return $response->Id;
        } catch (\Throwable $th) {

        }
    }
    public function createUBO($mangoUser , $request)
    {
        
        $NewUBO = $this->mangoPayApi->UboDeclarations->Create($mangoUser);


        $userId = $mangoUser;
        $uboDeclarationId = $NewUBO->Id;
        $user = auth()->user();
        $seller_address = $user->seller_address;
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        


        $address = new \MangoPay\Address();
        $address->AddressLine1 = $seller_address->street_number;
        $address->AddressLine2 = $seller_address->street_number;
        $address->City = $seller_address->city;
        $address->Country = 'GB';
        $address->PostalCode = $seller_address->postal_code;
        $address->Region = $seller_address->city;
        
        $ubo = new \MangoPay\Ubo();
        $ubo->Address = $address;
        $ubo->FirstName = $user->first_name;
        $ubo->LastName = $user->last_name;
        $ubo->Nationality = $request->nationality;
        $ubo->Birthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975); 

        $Birthplace = new \MangoPay\Birthplace();
        $Birthplace->City = $request->city_of_birth;
        $Birthplace->Country = $request->nationality;

        $ubo->Birthplace = $Birthplace;

        $UboDeclarations = $this->mangoPayApi->UboDeclarations->CreateUbo($userId, $uboDeclarationId, $ubo);


        $response = $this->mangoPayApi->UboDeclarations->SubmitForValidation($mangoUser , $uboDeclarationId);

        UserKyc::create([
            'key'=>'ubo',
            'kyc_id'=>$uboDeclarationId,
            'user_id'=>auth()->user()->id
        ]);
        return $response;        
    }
    public function checkKycPayment($id)
    {
        try{
            return $this->mangoPayApi->PayIns->Get($id);
        }
        catch(Exception $e)
        {
            
        }
    }
    public function updateUbo($request)
    {
        try {
            $mangoUser = auth()->user()->store->mango_id;
            $NewUBO = $this->mangoPayApi->UboDeclarations->Create($mangoUser);


            $userId = $mangoUser;
            $uboDeclarationId = $NewUBO->Id;
            $user = auth()->user();
            $seller_address = $user->seller_address;
            $dateString = str_replace('/', '-', $user->dob);
            $dob = strtotime($dateString);
            


            $address = new \MangoPay\Address();
            $address->AddressLine1 = $request->street_number;
            $address->AddressLine2 = $request->street_number;
            $address->City = $request->city;
            $address->Country = 'GB';
            $address->PostalCode = $request->postal_code;
            $address->Region = $request->city;
            
            $ubo = new \MangoPay\Ubo();
            $ubo->Address = $address;
            $ubo->FirstName = $user->first_name;
            $ubo->LastName = $user->last_name;
            $ubo->Nationality = 'GB';
            $ubo->Birthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975); 

            $Birthplace = new \MangoPay\Birthplace();
            $Birthplace->City = $request->city;
            $Birthplace->Country = 'GB';

            $ubo->Birthplace = $Birthplace;

            $UboDeclarations = $this->mangoPayApi->UboDeclarations->CreateUbo($userId, $uboDeclarationId, $ubo);


            $response = $this->mangoPayApi->UboDeclarations->SubmitForValidation($mangoUser , $uboDeclarationId);

            $query = ['key'=>'ubo','user_id'=>auth()->user()->id,];
            $data = [
                'key'=>'ubo',
                'kyc_id'=>$uboDeclarationId,
                'user_id'=>auth()->user()->id,
                'mangopay_response'=>null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
            UserKyc::updateOrcreate($query , $data);

            return $response; 

        }catch(Exception $e) {
        }
    }
}