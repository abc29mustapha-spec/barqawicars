@php $vehicle = $vehicle ?? null; @endphp

@php
$input = "w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-colors";
$label = "block text-xs font-semibold text-gray-600 mb-1.5";
$card  = "bg-white border border-gray-200 rounded-xl mb-5 overflow-hidden";
$head  = "bg-gray-50 border-b border-gray-100 px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-500";
$body  = "p-5";
@endphp

{{-- Section 1: Basic info --}}
<div class="{{ $card }}">
    <div class="{{ $head }}">{{ __('admin.form_basic') }}</div>
    <div class="{{ $body }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <div>
                <label class="{{ $label }}">{{ __('admin.label_brand') }}</label>
                <select name="brand_id" required class="{{ $input }} {{ $errors->has('brand_id') ? 'border-red-400' : '' }}">
                    <option value="">{{ __('admin.select_brand') }}</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $vehicle?->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                <a href="{{ route('admin.marques.create') }}" target="_blank"
                   class="inline-block mt-1.5 text-xs text-blue-600 hover:text-blue-700">{{ __('admin.btn_add_brand') }}</a>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_model') }}</label>
                <input type="text" name="model" value="{{ old('model',$vehicle?->model) }}" required
                       class="{{ $input }}" placeholder="{{ __('admin.ph_model') }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_version') }}</label>
                <input type="text" name="version" value="{{ old('version',$vehicle?->version) }}"
                       class="{{ $input }}" placeholder="{{ __('admin.ph_version') }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_body_type') }}</label>
                <select name="vehicle_type" required class="{{ $input }}">
                    @foreach([
                        'cabriolet_roadster' => __('admin.body_cabriolet'),
                        'suv_pickup'         => __('admin.body_suv'),
                        'citadine'           => __('admin.body_citadine'),
                        'break'              => __('admin.body_break'),
                        'berline'            => __('admin.body_berline'),
                        'monospace_minibus'  => __('admin.body_monospace'),
                        'sport_coupe'        => __('admin.body_sport'),
                        'autre'              => __('admin.body_other'),
                    ] as $v => $l)
                        <option value="{{ $v }}" {{ old('vehicle_type',$vehicle?->vehicle_type)===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_condition') }}</label>
                <select name="condition" required class="{{ $input }}">
                    <option value="occasion" {{ old('condition',$vehicle?->condition)==='occasion'?'selected':'' }}>{{ __('admin.cond_used_opt') }}</option>
                    <option value="neuf"     {{ old('condition',$vehicle?->condition)==='neuf'    ?'selected':'' }}>{{ __('admin.cond_new_opt') }}</option>
                </select>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_seller') }}</label>
                <select name="seller_type" required class="{{ $input }}">
                    <option value="concessionnaire" {{ old('seller_type',$vehicle?->seller_type)==='concessionnaire'?'selected':'' }}>{{ __('admin.seller_dealer') }}</option>
                    <option value="particulier"     {{ old('seller_type',$vehicle?->seller_type)==='particulier'    ?'selected':'' }}>{{ __('admin.seller_private') }}</option>
                    <option value="societe"         {{ old('seller_type',$vehicle?->seller_type)==='societe'        ?'selected':'' }}>{{ __('admin.seller_company') }}</option>
                </select>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_year') }}</label>
                <input type="number" name="year" value="{{ old('year',$vehicle?->year) }}" required
                       min="1950" max="{{ date('Y')+1 }}" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_mileage') }}</label>
                <input type="number" name="mileage" value="{{ old('mileage',$vehicle?->mileage) }}" required min="0" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_price') }}</label>
                <input type="number" name="price" value="{{ old('price',$vehicle?->price) }}" required min="0" step="100" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_old_price') }} <span class="text-gray-400 font-normal text-xs">{{ __('admin.old_price_hint') }}</span></label>
                <input type="number" name="ancien_prix" value="{{ old('ancien_prix',$vehicle?->ancien_prix) }}" min="0" step="100" placeholder="{{ __('admin.ph_old_price') }}" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_vin_f') }}</label>
                <input type="text" name="vin" value="{{ old('vin',$vehicle?->vin) }}" maxlength="17"
                       placeholder="{{ __('admin.ph_vin') }}" class="{{ $input }} font-mono">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_status_f') }}</label>
                <select name="status" required class="{{ $input }}">
                    <option value="actif"   {{ old('status',$vehicle?->status??'actif')==='actif'  ?'selected':'' }}>{{ __('admin.status_actif') }}</option>
                    <option value="inactif" {{ old('status',$vehicle?->status)==='inactif'          ?'selected':'' }}>{{ __('admin.status_inactif') }}</option>
                    <option value="vendu"   {{ old('status',$vehicle?->status)==='vendu'            ?'selected':'' }}>{{ __('admin.status_vendu') }}</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Section 2: Technical data --}}
<div class="{{ $card }}">
    <div class="{{ $head }}">{{ __('admin.form_technical') }}</div>
    <div class="{{ $body }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <div>
                <label class="{{ $label }}">{{ __('admin.label_fuel') }}</label>
                <select name="fuel_type" required class="{{ $input }}">
                    @foreach([
                        'essence'             => __('admin.fuel_essence'),
                        'diesel'              => __('admin.fuel_diesel'),
                        'electrique'          => __('admin.fuel_electric'),
                        'bioethanol'          => __('admin.fuel_ethanol'),
                        'hybride_essence'     => __('admin.fuel_hybrid_e'),
                        'hybride_plug_in'     => __('admin.fuel_plugin'),
                        'gaz_naturel'         => __('admin.fuel_gas'),
                        'hybride_rechargeable'=> __('admin.fuel_recharge'),
                        'gpl'                 => __('admin.fuel_gpl'),
                        'autre'               => __('admin.fuel_other'),
                    ] as $v => $l)
                        <option value="{{ $v }}" {{ old('fuel_type',$vehicle?->fuel_type)===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_trans') }}</label>
                <select name="transmission" class="{{ $input }}">
                    <option value="">—</option>
                    <option value="automatique"      {{ old('transmission',$vehicle?->transmission)==='automatique'     ?'selected':'' }}>{{ __('admin.trans_auto') }}</option>
                    <option value="semi_automatique" {{ old('transmission',$vehicle?->transmission)==='semi_automatique'?'selected':'' }}>{{ __('admin.trans_semi') }}</option>
                    <option value="manuelle"         {{ old('transmission',$vehicle?->transmission)==='manuelle'        ?'selected':'' }}>{{ __('admin.trans_manual') }}</option>
                </select>
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_power_hp') }}</label>
                <input type="number" name="power_hp" value="{{ old('power_hp',$vehicle?->power_hp) }}" min="0" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_power_kw') }}</label>
                <input type="number" name="power_kw" value="{{ old('power_kw',$vehicle?->power_kw) }}" min="0" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_cylinder') }}</label>
                <input type="number" name="cylinder" value="{{ old('cylinder',$vehicle?->cylinder) }}" min="0" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">{{ __('admin.label_emission') }}</label>
                <input type="text" name="emission_standard" value="{{ old('emission_standard',$vehicle?->emission_standard) }}"
                       placeholder="{{ __('admin.ph_emission') }}" class="{{ $input }}">
            </div>

            @php
            $colorSwatches = [
                'beige'  => ['hex'=>'#D4C5A9','border'=>false],
                'bleu'   => ['hex'=>'#2563EB','border'=>false],
                'brun'   => ['hex'=>'#92400E','border'=>false],
                'jaune'  => ['hex'=>'#FACC15','border'=>false],
                'or'     => ['hex'=>'#CA8A04','border'=>false],
                'vert'   => ['hex'=>'#16A34A','border'=>false],
                'gris'   => ['hex'=>'#6B7280','border'=>false],
                'orange' => ['hex'=>'#EA580C','border'=>false],
                'rouge'  => ['hex'=>'#DC2626','border'=>false],
                'noir'   => ['hex'=>'#111827','border'=>false],
                'argent' => ['hex'=>'#CBD5E1','border'=>false],
                'violet' => ['hex'=>'#7C3AED','border'=>false],
                'blanc'  => ['hex'=>'#FFFFFF','border'=>true],
            ];
            @endphp

            @foreach([
                ['field'=>'exterior_color','label'=>__('admin.label_ext_color_f')],
                ['field'=>'interior_color','label'=>__('admin.label_int_color_f')],
            ] as $_cf)
            @php
                $_raw   = old($_cf['field'], $vehicle?->{$_cf['field']} ?? '');
                $_parts = $_raw ? explode('_', $_raw, 2) : [];
                $_col   = in_array($_parts[0] ?? '', array_keys($colorSwatches)) ? ($_parts[0] ?? '') : '';
                $_fin   = in_array($_parts[1] ?? '', ['mate','metallique'])       ? ($_parts[1] ?? '') : '';
            @endphp
            <div>
                <label class="{{ $label }}">{{ $_cf['label'] }}</label>
                <div x-data="{
                        c: '{{ $_col }}',
                        f: '{{ $_fin }}',
                        get v() { return this.c ? (this.f ? this.c + '_' + this.f : this.c) : '' },
                        pick(col) { this.c = this.c === col ? '' : col; if (!this.c) this.f = ''; },
                        fin(val)  { this.f = this.f === val ? '' : val; }
                     }"
                     class="p-3 border border-gray-200 rounded-xl bg-gray-50/80">

                    <input type="hidden" name="{{ $_cf['field'] }}" :value="v">

                    {{-- Swatches --}}
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach($colorSwatches as $cKey => $cProps)
                        <button type="button"
                                title="{{ ucfirst($cKey) }}"
                                @click="pick('{{ $cKey }}')"
                                :class="c === '{{ $cKey }}'
                                    ? 'ring-2 ring-offset-2 ring-gray-700 scale-110 shadow-md'
                                    : 'hover:scale-110 hover:shadow-sm'"
                                class="w-7 h-7 rounded-full transition-all duration-150 shrink-0 {{ $cProps['border'] ? 'border border-gray-300' : '' }}"
                                style="background:{{ $cProps['hex'] }};"></button>
                        @endforeach
                        {{-- Clear --}}
                        <button type="button"
                                x-show="c !== ''"
                                @click="c = ''; f = ''"
                                class="w-7 h-7 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400 hover:border-red-400 hover:text-red-400 transition-all shrink-0"
                                title="Effacer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Finish toggle --}}
                    <div class="flex items-center gap-2" x-show="c !== ''">
                        <span class="text-[11px] text-gray-400 font-medium">Finition :</span>
                        <button type="button"
                                @click="fin('mate')"
                                :class="f==='mate'
                                    ? 'bg-gray-800 text-white border-gray-800'
                                    : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400'"
                                class="px-2.5 py-1 rounded-lg text-[11px] font-semibold border transition-all">
                            Mate
                        </button>
                        <button type="button"
                                @click="fin('metallique')"
                                :class="f==='metallique'
                                    ? 'bg-gray-800 text-white border-gray-800'
                                    : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400'"
                                class="px-2.5 py-1 rounded-lg text-[11px] font-semibold border transition-all">
                            Métallique
                        </button>
                    </div>

                    {{-- Selected preview --}}
                    <div class="mt-2 flex items-center gap-2 min-h-[18px]" x-show="c !== ''">
                        @foreach($colorSwatches as $cKey => $cProps)
                        <div x-show="c === '{{ $cKey }}'"
                             class="w-3.5 h-3.5 rounded-full shrink-0 {{ $cProps['border'] ? 'border border-gray-400' : '' }}"
                             style="background:{{ $cProps['hex'] }};"></div>
                        @endforeach
                        <span class="text-[11px] text-gray-500 font-medium capitalize" x-text="v.replace('_', ' ')"></span>
                    </div>
                </div>
                @error($_cf['field'])<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            @endforeach

            <div>
                <label class="{{ $label }}">{{ __('admin.label_doors') }}</label>
                <input type="number" name="doors" value="{{ old('doors',$vehicle?->doors) }}" min="1" max="10" class="{{ $input }}">
            </div>
        </div>
    </div>
</div>

{{-- Section 3: Condition & options --}}
<div class="{{ $card }}">
    <div class="{{ $head }}">{{ __('admin.form_condition') }}</div>
    <div class="{{ $body }}">

        {{-- VAT --}}
        <div class="mb-5">
            <label class="{{ $label }}">{{ __('admin.label_vat_f') }}</label>
            <select name="vat_status" class="{{ $input }} max-w-xs">
                <option value="">{{ __('admin.vat_unspecified') }}</option>
                <option value="recuperable"     {{ old('vat_status',$vehicle?->vat_status)==='recuperable'     ?'selected':'' }}>{{ __('admin.vat_rec_opt') }}</option>
                <option value="non_recuperable" {{ old('vat_status',$vehicle?->vat_status)==='non_recuperable' ?'selected':'' }}>{{ __('admin.vat_non_rec_opt') }}</option>
            </select>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-5">
            @foreach([
                ['name'=>'warranty',        'label'=>__('admin.opt_warranty')],
                ['name'=>'full_service',    'label'=>__('admin.opt_full_service')],
                ['name'=>'service_book',    'label'=>__('admin.opt_service_book')],
                ['name'=>'safety_compliant','label'=>__('admin.opt_safety')],
                ['name'=>'non_smoker',      'label'=>__('admin.opt_non_smoker')],
                ['name'=>'dpf',             'label'=>__('admin.opt_dpf')],
            ] as $opt)
                <label class="flex items-center gap-2.5 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/50 transition-colors select-none">
                    <input type="checkbox" name="{{ $opt['name'] }}" value="1"
                           {{ old($opt['name'],$vehicle?->{$opt['name']})?'checked':'' }}
                           class="w-4 h-4 rounded accent-blue-600 cursor-pointer">
                    <span class="text-sm text-gray-700">{{ $opt['label'] }}</span>
                </label>
            @endforeach
        </div>

        <div>
            <label class="{{ $label }}">{{ __('admin.label_description') }}</label>
            <textarea name="description" rows="4"
                      class="{{ $input }} resize-none"
                      placeholder="{{ __('admin.ph_description') }}">{{ old('description',$vehicle?->description) }}</textarea>
        </div>
    </div>
</div>

{{-- Section 4: Photos --}}
<div class="{{ $card }}">
    <div class="{{ $head }}">{{ __('admin.photos') }}</div>
    <div class="{{ $body }}">

        @if(isset($vehicle) && $vehicle?->id)
            {{-- ── EDIT MODE : opérations via fetch (routes images) ── --}}
            @php
                $imagesJson = $vehicle->images->map(fn($img) => [
                    'id'      => $img->id,
                    'url'     => \Illuminate\Support\Facades\Storage::url($img->image_path),
                    'is_main' => (bool) $img->is_main,
                ])->toJson();
                $storeUrl = route('admin.vehicles.images.store', $vehicle);
            @endphp

            <div x-data="vehicleImages(
                    '{{ $storeUrl }}',
                    {{ $imagesJson }}
                )">

                {{-- Grille des images existantes --}}
                <div x-show="images.length > 0"
                     class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-4">
                    <template x-for="img in images" :key="img.id">
                        <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 group cursor-default">
                            <img :src="img.url" class="w-full h-full object-cover">

                            <span x-show="img.is_main"
                                  class="absolute top-1 left-1 bg-blue-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded leading-tight">
                                Principal
                            </span>

                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button type="button"
                                        x-show="!img.is_main"
                                        @click="setMain(img.id)"
                                        title="Définir comme principale"
                                        class="w-7 h-7 bg-blue-500 hover:bg-blue-600 text-white rounded-full text-sm flex items-center justify-center leading-none">
                                    ★
                                </button>
                                <button type="button"
                                        @click="remove(img.id)"
                                        title="Supprimer"
                                        class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs font-bold flex items-center justify-center">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <p x-show="images.length === 0"
                   class="text-sm text-gray-400 text-center py-3 mb-3">
                    Aucune photo pour ce véhicule.
                </p>

                {{-- Zone d'ajout de nouvelles photos --}}
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors"
                     :class="isDragging ? 'border-blue-500 bg-blue-50' : (uploading ? 'pointer-events-none opacity-60' : '')"
                     @dragover.prevent="if(!uploading) isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; if(!uploading) upload(Array.from($event.dataTransfer.files).filter(f => f.type.startsWith('image/')))"
                     @click="if(!uploading) $refs.addFi.click()">

                    <div x-show="!uploading">
                        <svg class="w-7 h-7 text-gray-300 mx-auto mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500">Ajouter des photos</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WEBP · 5 Mo max par image</p>
                    </div>

                    <div x-show="uploading" class="py-1">
                        <svg class="w-6 h-6 text-blue-500 mx-auto animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <p class="text-sm text-blue-500 mt-1.5">Envoi en cours…</p>
                    </div>

                    <input type="file" multiple accept="image/jpeg,image/png,image/webp"
                           x-ref="addFi"
                           @change="upload(Array.from($event.target.files))"
                           class="hidden">
                </div>
            </div>

        @else
            {{-- ── CREATE MODE : input dans le formulaire principal ── --}}
            <div x-data="imgUploader()">
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors"
                     :class="isDragging ? 'border-blue-500 bg-blue-50' : ''"
                     @dragover.prevent="isDragging=true"
                     @dragleave.prevent="isDragging=false"
                     @drop.prevent="drop($event)"
                     @click="$refs.fi.click()">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500" x-show="!previews.length">{{ __('admin.ph_drag_create') }}</p>
                    <p class="text-xs text-gray-400 mt-1" x-show="!previews.length">{{ __('admin.photo_hint_create') }}</p>
                    <p class="text-sm font-semibold text-blue-600" x-show="previews.length"
                       x-text="previews.length + ' {{ addslashes(__('admin.photo_count_create', ['count' => ''])) }}'"></p>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                           x-ref="fi" @change="pick($event)" class="hidden">
                </div>

                <div x-show="previews.length" class="grid grid-cols-5 gap-2 mt-3">
                    <template x-for="(p,i) in previews" :key="i">
                        <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100">
                            <img :src="p" class="w-full h-full object-cover">
                            <span x-show="i===0" class="absolute top-1 left-1 bg-blue-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ __('admin.label_main') }}</span>
                            <button type="button" @click.stop="remove(i)"
                                    class="absolute top-0.5 right-0.5 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full text-[10px] font-bold flex items-center justify-center">✕</button>
                        </div>
                    </template>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
function imgUploader() {
    return {
        previews: [], isDragging: false, files: new DataTransfer(),
        pick(e)  { this.addFiles(Array.from(e.target.files)); },
        drop(e)  { this.isDragging = false; this.addFiles(Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))); },
        addFiles(list) {
            list.forEach(f => {
                if (f.size > 5 * 1024 * 1024) { alert(f.name + ' dépasse 5 Mo'); return; }
                const r = new FileReader();
                r.onload = e => this.previews.push(e.target.result);
                r.readAsDataURL(f);
                this.files.items.add(f);
            });
            this.$refs.fi.files = this.files.files;
        },
        remove(i) {
            this.previews.splice(i, 1);
            const d = new DataTransfer();
            Array.from(this.files.files).filter((_, j) => j !== i).forEach(f => d.items.add(f));
            this.files = d; this.$refs.fi.files = d.files;
        }
    };
}

function vehicleImages(storeUrl, initial) {
    return {
        images: initial,
        uploading: false,
        isDragging: false,

        csrf() {
            return document.head.querySelector('meta[name="csrf-token"]').content;
        },

        imgUrl(id, suffix) {
            return storeUrl + '/' + id + (suffix || '');
        },

        async upload(files) {
            if (!files.length) return;
            const fd = new FormData();
            files.forEach(f => fd.append('images[]', f));
            fd.append('_token', this.csrf());
            this.uploading = true;
            try {
                const resp = await fetch(storeUrl, { method: 'POST', body: fd });
                if (resp.ok || resp.redirected) window.location.reload();
                else alert('Erreur lors de l\'envoi des images.');
            } catch (e) {
                alert('Erreur réseau.');
            } finally {
                this.uploading = false;
            }
        },

        async remove(id) {
            if (!confirm('Supprimer cette image ?')) return;
            await fetch(this.imgUrl(id), {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': this.csrf() }
            });
            this.images = this.images.filter(i => i.id !== id);
            if (this.images.length > 0 && !this.images.some(i => i.is_main)) {
                this.images[0].is_main = true;
            }
        },

        async setMain(id) {
            await fetch(this.imgUrl(id, '/principale'), {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': this.csrf() }
            });
            this.images = this.images.map(i => ({ ...i, is_main: i.id === id }));
        }
    };
}
</script>
@endpush
