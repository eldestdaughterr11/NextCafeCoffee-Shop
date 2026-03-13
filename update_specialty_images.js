const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

async function main() {
  const updates = [
    {
      name: "Saira's Salted Machiatta",
      image: "/images/Saira's Salted Machiatta.png"
    },
    {
      name: "Nell's Caramel Hell",
      image: "/images/Nell's Caramel Hell.png"
    },
    {
      name: "Van's Flat Leche Flan",
      image: "/images/van's flat leche flan.png"
    },
    {
      name: "Martin's Black Choco Macho",
      image: "/images/Martin's black choco.png"
    }
  ];

  for (const update of updates) {
    const product = await prisma.product.findFirst({
      where: { name: update.name }
    });

    if (product) {
      await prisma.product.update({
        where: { id: product.id },
        data: { image: update.image }
      });
      console.log(`✅ Updated image for: ${update.name}`);
    } else {
      console.log(`❌ Product not found: ${update.name}`);
    }
  }
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
