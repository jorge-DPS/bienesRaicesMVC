<fieldset>

    <legend>Información General</legend>

    <label for="nombre">Nombre</label>
    <input type="text" id="titulo" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value="<?php echo sanitizar($vendedor->nombre); ?>">

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value="<?php echo sanitizar($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Informacion Extra</legend>
    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="telefono Vendedor(a)" value="<?php echo sanitizar($vendedor->telefono); ?>">
</fieldset>