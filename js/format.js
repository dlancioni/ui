/*
 * Format value
 */
function formatValue(value) {
    value = valueOf(value);
    let x = new Intl.NumberFormat("pt-BR", {minimumFractionDigits: 2}).format(value);
    return x;
}
